<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        //  $this->middleware('permission:notification-list', ['only' => ['index','getUnreadNotifications','getUnreadCount','loadMore']]);
        // $this->middleware('permission:notification-mark-read', ['only' => ['markAsRead','markAllAsRead']]);
        // $this->middleware('permission:notification-create', ['only' => ['create','store']]);
        // $this->middleware('permission:notification-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:notification-delete', ['only' => ['destroy']]);
    }

    /**
     * Lấy thông báo chưa đọc (cho dropdown)
     */
    public function getUnreadNotifications()
    {
        $userId = Auth::id();
        $notifications = $this->notificationService->getUnreadNotifications($userId, 10);
        $unreadCount = $this->notificationService->getUnreadCount($userId);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Hiển thị trang danh sách thông báo
     */
    public function index()
    {
        $userId = Auth::id();
        $notifications = $this->notificationService->getUserNotifications($userId);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Đánh dấu thông báo đã đọc
     */
    public function markAsRead(Request $request, $id)
    {
        $userId = Auth::id();
        $success = $this->notificationService->markAsRead($id, $userId);

        if ($request->wantsJson()) {
            return response()->json(['success' => $success]);
        }

        return redirect()->back();
    }

    /**
     * Đánh dấu tất cả thông báo đã đọc
     */
    public function markAllAsRead(Request $request)
    {
        $userId = Auth::id();
        $count = $this->notificationService->markAllAsRead($userId);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Đã đánh dấu {$count} thông báo là đã đọc"
            ]);
        }

        return redirect()->back()->with('success', "Đã đánh dấu {$count} thông báo là đã đọc");
    }

    /**
     * Lấy số lượng thông báo chưa đọc
     */
    public function getUnreadCount()
    {
        $userId = Auth::id();
        $count = $this->notificationService->getUnreadCount($userId);

        return response()->json(['count' => $count]);
    }

    /**
     * API endpoint để load thêm thông báo (cho infinite scroll)
     */
    public function loadMore(Request $request)
    {
        $userId = Auth::id();
        $page = $request->get('page', 1);

        $notifications = $this->notificationService->getUserNotifications($userId, 10);

        return response()->json([
            'notifications' => $notifications->items(),
            'has_more' => $notifications->hasMorePages(),
            'next_page' => $notifications->currentPage() + 1
        ]);
    }
}
