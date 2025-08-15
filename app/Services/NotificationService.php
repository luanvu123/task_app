<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Task;
use App\Models\Message;
use App\Models\User;

class NotificationService
{
    /**
     * Tạo thông báo khi có task mới
     */
    public function createTaskNotification(Task $task, $fromUserId)
    {
        return Notification::createTaskNotification($task, $fromUserId);
    }

    /**
     * Tạo thông báo khi task được cập nhật
     */
    public function createTaskUpdateNotification(Task $task, $fromUserId, $updateType = 'updated')
    {
        $messages = [
            'updated' => 'Công việc của bạn đã được cập nhật: ',
            'completed' => 'Công việc của bạn đã được đánh dấu hoàn thành: ',
            'status_changed' => 'Trạng thái công việc đã thay đổi: '
        ];

        return Notification::create([
            'type' => Notification::TYPE_TASK,
            'user_id' => $task->user_id,
            'from_user_id' => $fromUserId,
            'title' => 'Cập nhật công việc',
            'message' => $messages[$updateType] . $task->name,
            'data' => [
                'task_id' => $task->id,
                'task_name' => $task->name,
                'project_name' => $task->project->name ?? '',
                'status' => $task->status,
                'update_type' => $updateType
            ],
            'url' => route('tasks.show', $task->id)
        ]);
    }

    /**
     * Tạo thông báo khi có tin nhắn mới
     */
    public function createMessageNotification(Message $message)
    {
        // Lấy danh sách participants trừ người gửi
        $participantIds = $message->conversation->participants()
            ->where('user_id', '!=', $message->user_id)
            ->pluck('user_id')
            ->toArray();

        return Notification::createMessageNotification($message, $participantIds);
    }

    /**
     * Lấy thông báo chưa đọc của user
     */
    public function getUnreadNotifications($userId, $limit = 10)
    {
        return Notification::forUser($userId)
            ->unread()
            ->with('fromUser')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Lấy tất cả thông báo của user (có phân trang)
     */
    public function getUserNotifications($userId, $perPage = 15)
    {
        return Notification::forUser($userId)
            ->with('fromUser')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Đánh dấu tất cả thông báo đã đọc
     */
    public function markAllAsRead($userId)
    {
        return Notification::forUser($userId)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }

    /**
     * Đánh dấu thông báo đã đọc
     */
    public function markAsRead($notificationId, $userId)
    {
        $notification = Notification::forUser($userId)->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    /**
     * Đếm số thông báo chưa đọc
     */
    public function getUnreadCount($userId)
    {
        return Notification::forUser($userId)->unread()->count();
    }

    /**
     * Xóa thông báo cũ (hơn 30 ngày)
     */
    public function cleanupOldNotifications()
    {
        return Notification::where('created_at', '<', now()->subDays(30))
            ->delete();
    }

    /**
     * Tạo thông báo hệ thống
     */
    public function createSystemNotification($userIds, $title, $message, $url = null)
    {
        $notifications = [];

        foreach ((array) $userIds as $userId) {
            $notifications[] = [
                'type' => Notification::TYPE_SYSTEM,
                'user_id' => $userId,
                'from_user_id' => null,
                'title' => $title,
                'message' => $message,
                'data' => null,
                'url' => $url,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        if (!empty($notifications)) {
            Notification::insert($notifications);
        }
    }

    /**
     * Tạo thông báo cho tất cả users trong department
     */
    public function createDepartmentNotification($departmentId, $title, $message, $url = null)
    {
        $userIds = User::where('department_id', $departmentId)
            ->where('status', 'active')
            ->pluck('id')
            ->toArray();

        if (!empty($userIds)) {
            $this->createSystemNotification($userIds, $title, $message, $url);
        }
    }
}
