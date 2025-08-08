<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị trang chat chính
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        // Đảm bảo participants được eager load
        $conversations = $currentUser->conversations()
            ->with(['lastMessage.user', 'participants'])
            ->orderByDesc('last_message_at')
            ->get();

        // Lấy conversation hiện tại nếu có
        $currentConversation = null;
        $messages = collect();

        if ($request->has('conversation_id')) {
            $currentConversation = Conversation::with(['participants', 'messages.user'])
                ->where('id', $request->conversation_id)
                ->whereHas('participants', function($query) use ($currentUser) {
                    $query->where('user_id', $currentUser->id);
                })
                ->first();

            if ($currentConversation) {
                // Đảm bảo participants được load
                if (!$currentConversation->relationLoaded('participants')) {
                    $currentConversation->load('participants');
                }

                $messages = $currentConversation->messages()
                    ->with('user')
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Cập nhật last_read_at
                try {
                    $currentConversation->participants()
                        ->updateExistingPivot($currentUser->id, [
                            'last_read_at' => now()
                        ]);
                } catch (\Exception $e) {
                    // Log lỗi nhưng không dừng execution
                    \Log::warning('Failed to update last_read_at: ' . $e->getMessage());
                }
            }
        }

        // Lấy danh sách users để tạo conversation mới
        $users = User::where('id', '!=', $currentUser->id)
            ->where('status', 'active')
            ->get();

        // Lấy danh sách group conversations với participants được load
        $groupConversations = $currentUser->conversations()
            ->where('type', 'group')
            ->with(['lastMessage.user', 'participants'])
            ->orderByDesc('last_message_at')
            ->get();

        return view('messages.index', compact(
            'conversations',
            'currentConversation',
            'messages',
            'users',
            'groupConversations',
            'currentUser'
        ));
    }

    /**
     * Tạo cuộc trò chuyện mới với user
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $currentUserId = Auth::id();
        $targetUserId = $request->user_id;

        if ($currentUserId == $targetUserId) {
            return redirect()->back()->with('error', 'Không thể tạo cuộc trò chuyện với chính mình');
        }

        try {
            // Tìm hoặc tạo conversation private
            $conversation = Conversation::createOrFindPrivate($currentUserId, $targetUserId);
            return redirect()->route('messages.index', ['conversation_id' => $conversation->id]);
        } catch (\Exception $e) {
            \Log::error('Error creating conversation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo cuộc trò chuyện');
        }
    }

    /**
     * Tạo nhóm chat
     */
    public function createGroup(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id'
        ]);

        $currentUserId = Auth::id();
        $participants = array_unique(array_merge([$currentUserId], $request->participants));

        DB::beginTransaction();
        try {
            $conversation = Conversation::create([
                'title' => $request->title,
                'type' => 'group',
                'created_by' => $currentUserId
            ]);

            // Attach participants với pivot data
            $participantData = [];
            foreach ($participants as $userId) {
                $participantData[$userId] = ['joined_at' => now()];
            }
            $conversation->participants()->attach($participantData);

            // Tạo tin nhắn hệ thống
            Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $currentUserId,
                'content' => Auth::user()->name . ' đã tạo nhóm chat',
                'type' => 'system'
            ]);

            $conversation->update(['last_message_at' => now()]);

            DB::commit();

            return redirect()->route('messages.index', ['conversation_id' => $conversation->id])
                ->with('success', 'Nhóm chat đã được tạo thành công');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating group: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo nhóm chat');
        }
    }

    /**
     * Gửi tin nhắn
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required|string|max:5000',
            'reply_to' => 'nullable|exists:messages,id'
        ]);

        $currentUser = Auth::user();
        $conversation = Conversation::with('participants')->findOrFail($request->conversation_id);

        // Kiểm tra user có trong conversation không
        if (!$conversation->hasParticipant($currentUser->id)) {
            return response()->json(['error' => 'Bạn không có quyền gửi tin nhắn'], 403);
        }

        DB::beginTransaction();
        try {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $currentUser->id,
                'content' => $request->content,
                'reply_to' => $request->reply_to
            ]);

            // Cập nhật thời gian tin nhắn cuối cùng
            $conversation->update(['last_message_at' => now()]);

            DB::commit();

            // Load user relationship để trả về
            $message->load('user');

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error sending message: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Không thể gửi tin nhắn'], 500);
            }

            return redirect()->back()->with('error', 'Không thể gửi tin nhắn');
        }
    }

    /**
     * Lấy tin nhắn mới (cho AJAX)
     */
    public function getMessages(Request $request, $conversationId)
    {
        try {
            $conversation = Conversation::with('participants')->findOrFail($conversationId);
            $currentUser = Auth::user();

            if (!$conversation->hasParticipant($currentUser->id)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $lastMessageId = $request->get('last_message_id', 0);

            $messages = $conversation->messages()
                ->with('user')
                ->where('id', '>', $lastMessageId)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'messages' => $messages,
                'conversation' => $conversation
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting messages: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy tin nhắn'], 500);
        }
    }

    /**
     * Tìm kiếm conversations
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $currentUser = Auth::user();

        if (empty($query)) {
            return response()->json(['conversations' => []]);
        }

        try {
            $conversations = $currentUser->conversations()
                ->with(['lastMessage.user', 'participants'])
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhereHas('participants', function($subQ) use ($query) {
                          $subQ->where('name', 'like', "%{$query}%");
                      });
                })
                ->orderByDesc('last_message_at')
                ->get();

            return response()->json(['conversations' => $conversations]);
        } catch (\Exception $e) {
            \Log::error('Error searching conversations: ' . $e->getMessage());
            return response()->json(['conversations' => []]);
        }
    }

    /**
     * Thêm participants vào nhóm
     */
    public function addParticipants(Request $request, $conversationId)
    {
        $request->validate([
            'participants' => 'required|array',
            'participants.*' => 'exists:users,id'
        ]);

        $conversation = Conversation::with('participants')->findOrFail($conversationId);
        $currentUser = Auth::user();

        if ($conversation->type !== 'group') {
            return response()->json(['error' => 'Chỉ có thể thêm thành viên vào nhóm chat'], 400);
        }

        if (!$conversation->hasParticipant($currentUser->id)) {
            return response()->json(['error' => 'Bạn không có quyền thêm thành viên'], 403);
        }

        // Lọc ra những user chưa có trong nhóm
        $existingParticipants = $conversation->participants()->pluck('user_id')->toArray();
        $newParticipants = array_diff($request->participants, $existingParticipants);

        if (empty($newParticipants)) {
            return response()->json(['error' => 'Tất cả người dùng đã có trong nhóm'], 400);
        }

        DB::beginTransaction();
        try {
            // Attach với pivot data
            $participantData = [];
            foreach ($newParticipants as $userId) {
                $participantData[$userId] = ['joined_at' => now()];
            }
            $conversation->participants()->attach($participantData);

            // Tạo tin nhắn hệ thống
            $addedUsers = User::whereIn('id', $newParticipants)->pluck('name')->toArray();
            Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $currentUser->id,
                'content' => $currentUser->name . ' đã thêm ' . implode(', ', $addedUsers) . ' vào nhóm',
                'type' => 'system'
            ]);

            $conversation->update(['last_message_at' => now()]);

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error adding participants: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể thêm thành viên'], 500);
        }
    }

    /**
     * Rời khỏi nhóm chat
     */
    public function leaveGroup($conversationId)
    {
        $conversation = Conversation::with('participants')->findOrFail($conversationId);
        $currentUser = Auth::user();

        if ($conversation->type !== 'group') {
            return response()->json(['error' => 'Chỉ có thể rời khỏi nhóm chat'], 400);
        }

        if (!$conversation->hasParticipant($currentUser->id)) {
            return response()->json(['error' => 'Bạn không có trong nhóm này'], 400);
        }

        DB::beginTransaction();
        try {
            $conversation->participants()->detach($currentUser->id);

            // Tạo tin nhắn hệ thống
            Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $currentUser->id,
                'content' => $currentUser->name . ' đã rời khỏi nhóm',
                'type' => 'system'
            ]);

            $conversation->update(['last_message_at' => now()]);

            DB::commit();

            return redirect()->route('messages.index')
                ->with('success', 'Đã rời khỏi nhóm chat');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error leaving group: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể rời khỏi nhóm'], 500);
        }
    }
}
