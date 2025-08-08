<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project_id',
        'image_and_document',
        'user_id',
        'start_date',
        'end_date',
        'priority',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'image_and_document' => 'array',
    ];

    /**
     * Enum values for status
     */
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_NEEDS_REVIEW = 'needs_review';
    const STATUS_COMPLETED = 'completed';

    /**
     * Enum values for priority
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    /**
     * Quan hệ với Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Quan hệ với User (người được giao task)
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope để lọc theo trạng thái
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope để lọc theo độ ưu tiên
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope để lọc theo dự án
     */
    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope để lọc theo người được giao
     */
    public function scopeByAssignee($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Kiểm tra xem task có quá hạn không
     */
    public function isOverdue()
    {
        return $this->end_date < now() && $this->status !== self::STATUS_COMPLETED;
    }

    /**
     * Lấy danh sách tất cả statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_IN_PROGRESS => 'Đang thực hiện',
            self::STATUS_NEEDS_REVIEW => 'Cần xem xét',
            self::STATUS_COMPLETED => 'Hoàn thành'
        ];
    }

    /**
     * Lấy danh sách tất cả priorities
     */
    public static function getPriorities()
    {
        return [
            self::PRIORITY_LOW => 'Thấp',
            self::PRIORITY_MEDIUM => 'Trung bình',
            self::PRIORITY_HIGH => 'Cao',
            self::PRIORITY_URGENT => 'Khẩn cấp'
        ];
    }

    /**
     * Lấy màu badge cho priority
     */
    public function getPriorityBadgeColor()
    {
        return match ($this->priority) {
            self::PRIORITY_LOW => 'bg-secondary',
            self::PRIORITY_MEDIUM => 'bg-warning',
            self::PRIORITY_HIGH => 'bg-danger',
            self::PRIORITY_URGENT => 'bg-dark',
            default => 'bg-secondary'
        };
    }

    /**
     * Lấy màu badge cho status
     */
    public function getStatusBadgeColor()
    {
        return match ($this->status) {
            self::STATUS_IN_PROGRESS => 'light-success-bg',
            self::STATUS_NEEDS_REVIEW => 'light-info-bg',
            self::STATUS_COMPLETED => 'light-secondary-bg',
            default => 'light-secondary-bg'
        };
    }
}
