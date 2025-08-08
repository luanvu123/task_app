<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'created_by',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    // Loại bỏ 'participants' khỏi fillable và casts vì chúng ta dùng relationship

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants', 'conversation_id', 'user_id')
                    ->withPivot('joined_at', 'last_read_at')
                    ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Tìm cuộc trò chuyện riêng tư giữa 2 users
     */
    public static function findPrivateConversation($userId1, $userId2)
    {
        return self::where('type', 'private')
            ->whereHas('participants', function($query) use ($userId1) {
                $query->where('user_id', $userId1);
            })
            ->whereHas('participants', function($query) use ($userId2) {
                $query->where('user_id', $userId2);
            })
            ->whereHas('participants', function($query) use ($userId1, $userId2) {
                // Đảm bảo chỉ có đúng 2 participants
                $query->havingRaw('COUNT(*) = 2');
            }, '=', 2)
            ->first();
    }

    /**
     * Tạo hoặc tìm cuộc trò chuyện riêng tư
     */
    public static function createOrFindPrivate($userId1, $userId2)
    {
        $conversation = self::findPrivateConversation($userId1, $userId2);

        if (!$conversation) {
            \DB::beginTransaction();
            try {
                $conversation = self::create([
                    'type' => 'private',
                    'created_by' => $userId1
                ]);

                $conversation->participants()->attach([
                    $userId1 => ['joined_at' => now()],
                    $userId2 => ['joined_at' => now()]
                ]);

                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                throw $e;
            }
        }

        return $conversation;
    }

    /**
     * Kiểm tra user có trong cuộc trò chuyện không
     */
    public function hasParticipant($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }

    /**
     * Lấy tên hiển thị của cuộc trò chuyện
     */
    public function getDisplayName($currentUserId = null)
    {
        if ($this->type === 'group') {
            return $this->title ?: 'Nhóm chat';
        }

        if ($currentUserId) {
            $otherUser = $this->participants()->where('user_id', '!=', $currentUserId)->first();
            return $otherUser ? $otherUser->name : 'Cuộc trò chuyện';
        }

        return 'Cuộc trò chuyện riêng tư';
    }

    /**
     * Accessor để đảm bảo participants luôn được load
     */
    public function getParticipantsAttribute($value)
    {
        if (!$this->relationLoaded('participants')) {
            $this->load('participants');
        }

        return $this->getRelation('participants');
    }
}
