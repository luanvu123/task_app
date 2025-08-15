<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'from_user_id',
        'title',
        'message',
        'data',
        'url',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Các loại thông báo
    const TYPE_TASK = 'task';
    const TYPE_MESSAGE = 'message';
    const TYPE_SYSTEM = 'system';
    const TYPE_PROJECT = 'project';

    /**
     * Quan hệ với User (người nhận)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với User (người gửi)
     */
    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Scope cho thông báo chưa đọc
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope cho thông báo đã đọc
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope theo loại thông báo
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope cho user cụ thể
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Đánh dấu đã đọc
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    /**
     * Lấy thời gian hiển thị (relative time)
     */
    public function getTimeAgoAttribute()
    {
        $diff = $this->created_at->diffInMinutes(now());

        if ($diff < 1) {
            return 'Vừa xong';
        } elseif ($diff < 60) {
            return $diff . ' phút';
        } elseif ($diff < 1440) { // 24 hours
            return $this->created_at->diffInHours(now()) . ' giờ';
        } else {
            return $this->created_at->diffInDays(now()) . ' ngày';
        }
    }

    /**
     * Lấy icon theo loại thông báo
     */
    public function getIconAttribute()
    {
        return match ($this->type) {
            self::TYPE_TASK => 'icofont-tasks',
            self::TYPE_MESSAGE => 'icofont-chat',
            self::TYPE_PROJECT => 'icofont-briefcase',
            self::TYPE_SYSTEM => 'icofont-info-circle',
            default => 'icofont-notification'
        };
    }

    /**
     * Lấy màu badge theo loại thông báo
     */
    public function getBadgeColorAttribute()
    {
        return match ($this->type) {
            self::TYPE_TASK => 'bg-success',
            self::TYPE_MESSAGE => 'bg-primary',
            self::TYPE_PROJECT => 'bg-warning',
            self::TYPE_SYSTEM => 'bg-info',
            default => 'bg-secondary'
        };
    }

    /**
     * Tạo thông báo task mới
     */
    public static function createTaskNotification($task, $fromUserId)
    {
        return self::create([
            'type' => self::TYPE_TASK,
            'user_id' => $task->user_id,
            'from_user_id' => $fromUserId,
            'title' => 'Công việc mới được giao',
            'message' => 'Bạn được giao công việc: ' . $task->name,
            'data' => [
                'task_id' => $task->id,
                'task_name' => $task->name,
                'project_name' => $task->project->name ?? '',
                'priority' => $task->priority
            ],
            'url' => route('tasks.show', $task->id)
        ]);
    }

    /**
     * Tạo thông báo tin nhắn mới
     */
    public static function createMessageNotification($message, $participantIds)
    {
        $notifications = [];

        foreach ($participantIds as $participantId) {
            // Không tạo thông báo cho người gửi
            if ($participantId == $message->user_id) {
                continue;
            }

            $notifications[] = [
                'type' => self::TYPE_MESSAGE,
                'user_id' => $participantId,
                'from_user_id' => $message->user_id,
                'title' => 'Tin nhắn mới',
                'message' => $message->user->name . ' đã gửi tin nhắn mới',
                'data' => [
                    'conversation_id' => $message->conversation_id,
                    'message_id' => $message->id,
                    'sender_name' => $message->user->name
                ],
                'url' => route('conversations.show', $message->conversation_id),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        if (!empty($notifications)) {
            self::insert($notifications);
        }
    }

    /**
     * Lấy danh sách loại thông báo
     */
    public static function getTypes()
    {
        return [
            self::TYPE_TASK => 'Công việc',
            self::TYPE_MESSAGE => 'Tin nhắn',
            self::TYPE_PROJECT => 'Dự án',
            self::TYPE_SYSTEM => 'Hệ thống'
        ];
    }
}
