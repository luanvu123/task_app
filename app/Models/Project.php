<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
        'image_and_document',
        'start_date',
        'end_date',
        'notification_sent',
        'budget',
        'priority',
        'description',
        'status',
        'manager_id', // Thêm manager để quản lý dự án
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'image_and_document' => 'array', // Cast to array for JSON storage
    ];

    /**
     * Enum values for notification_sent
     */
    const NOTIFICATION_DEPARTMENT_HEAD = 'department_head';
    const NOTIFICATION_ALL = 'all';

    /**
     * Enum values for status
     */
    const STATUS_PLANNING = 'planning';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_ON_HOLD = 'on_hold';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Enum values for priority
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    /**
     * Quan hệ với Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Quan hệ với User (Project Manager)
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Quan hệ với User (Project Members) - Many to Many
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
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
     * Scope để lọc theo phòng ban
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Accessor để format budget
     */
    public function getFormattedBudgetAttribute()
    {
        return number_format($this->budget, 0, ',', '.') . ' VNĐ';
    }

    /**
     * Kiểm tra xem dự án có đang hoạt động không
     */
    public function isActive()
    {
        return in_array($this->status, [self::STATUS_PLANNING, self::STATUS_IN_PROGRESS]);
    }

    /**
     * Kiểm tra xem dự án có quá hạn không
     */
    public function isOverdue()
    {
        return $this->end_date < now() && $this->status !== self::STATUS_COMPLETED;
    }

    /**
     * Lấy danh sách tất cả notification types
     */
    public static function getNotificationTypes()
    {
        return [
            self::NOTIFICATION_DEPARTMENT_HEAD => 'Trưởng phòng',
            self::NOTIFICATION_ALL => 'Tất cả'
        ];
    }

    /**
     * Lấy danh sách tất cả statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PLANNING => 'Đang lên kế hoạch',
            self::STATUS_IN_PROGRESS => 'Đang thực hiện',
            self::STATUS_ON_HOLD => 'Tạm dừng',
            self::STATUS_COMPLETED => 'Hoàn thành',
            self::STATUS_CANCELLED => 'Đã hủy'
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
 * Quan hệ với Task (Dự án có nhiều công việc)
 */
public function tasks()
{
    return $this->hasMany(Task::class);
}

/**
 * Lấy các task đang thực hiện
 */
public function inProgressTasks()
{
    return $this->tasks()->where('status', Task::STATUS_IN_PROGRESS);
}

/**
 * Lấy các task cần xem xét
 */
public function needsReviewTasks()
{
    return $this->tasks()->where('status', Task::STATUS_NEEDS_REVIEW);
}

/**
 * Lấy các task đã hoàn thành
 */
public function completedTasks()
{
    return $this->tasks()->where('status', Task::STATUS_COMPLETED);
}

/**
 * Tính phần trăm hoàn thành dự án dựa trên tasks
 */
public function getCompletionPercentageAttribute()
{
    $totalTasks = $this->tasks()->count();
    if ($totalTasks === 0) {
        return 0;
    }

    $completedTasks = $this->completedTasks()->count();
    return round(($completedTasks / $totalTasks) * 100, 2);
}

/**
 * Kiểm tra xem dự án có tasks quá hạn không
 */
public function hasOverdueTasks()
{
    return $this->tasks()
        ->where('end_date', '<', now())
        ->where('status', '!=', Task::STATUS_COMPLETED)
        ->exists();
}

}

