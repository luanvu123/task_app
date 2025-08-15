<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'dob',
        'address',
        'description',
        'image',
        'position',
        'gender',
        'status',
        'nationality',
        'religion',
        'marital_status',
        'passport_no',
        'emergency_contact',
        'bank_name',
        'account_no',
        'ifsc_code',
        'pan_no',
        'upi_id',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'account_no',
        'ifsc_code',
        'pan_no',
        'passport_no',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
        'dob' => 'date', // Cast dob thành Carbon date instance
    ];

    /**
     * Get the user's full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        // Trả về ảnh mặc định nếu không có ảnh
        return asset('images/default-avatar.png');
    }

    /**
     * Get the user's status in Vietnamese
     */
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'active' => 'Hoạt động',
            'inactive' => 'Không hoạt động',
            'suspended' => 'Tạm ngưng',
            default => 'Không xác định'
        };
    }

    /**
     * Get the user's gender in Vietnamese
     */
    public function getGenderTextAttribute()
    {
        return match ($this->gender) {
            'male' => 'Nam',
            'female' => 'Nữ',
            'other' => 'Khác',
            default => 'Không xác định'
        };
    }

    /**
     * Get the user's marital status in Vietnamese
     */
    public function getMaritalStatusTextAttribute()
    {
        return match ($this->marital_status) {
            'single' => 'Độc thân',
            'married' => 'Đã kết hôn',
            'divorced' => 'Đã ly hôn',
            'widowed' => 'Góa',
            default => 'Không xác định'
        };
    }

    /**
     * Get the user's age
     */
    public function getAgeAttribute()
    {
        if ($this->dob) {
            return $this->dob->age;
        }
        return null;
    }

    /**
     * Get masked account number for security
     */
    public function getMaskedAccountNoAttribute()
    {
        if ($this->account_no) {
            $length = strlen($this->account_no);
            if ($length <= 4) {
                return str_repeat('*', $length);
            }
            return str_repeat('*', $length - 4) . substr($this->account_no, -4);
        }
        return null;
    }

    /**
     * Get masked PAN number for security
     */
    public function getMaskedPanNoAttribute()
    {
        if ($this->pan_no) {
            $length = strlen($this->pan_no);
            if ($length <= 4) {
                return str_repeat('*', $length);
            }
            return substr($this->pan_no, 0, 2) . str_repeat('*', $length - 4) . substr($this->pan_no, -2);
        }
        return null;
    }

    /**
     * Check if user has complete profile
     */
    public function getHasCompleteProfileAttribute()
    {
        $requiredFields = ['name', 'email', 'phone', 'dob', 'address'];
        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if user has banking info
     */
    public function getHasBankingInfoAttribute()
    {
        return !empty($this->bank_name) && !empty($this->account_no) && !empty($this->ifsc_code);
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope for suspended users
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Scope for users by nationality
     */
    public function scopeByNationality($query, $nationality)
    {
        return $query->where('nationality', $nationality);
    }

    /**
     * Scope for users by marital status
     */
    public function scopeByMaritalStatus($query, $status)
    {
        return $query->where('marital_status', $status);
    }

    /**
     * Scope for users with complete banking info
     */
    public function scopeWithBankingInfo($query)
    {
        return $query->whereNotNull('bank_name')
            ->whereNotNull('account_no')
            ->whereNotNull('ifsc_code');
    }

    /**
     * Conversations user tham gia
     */
    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('joined_at', 'last_read_at')
            ->orderByDesc('last_message_at');
    }

    /**
     * Messages của user
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Conversations user đã tạo
     */
    public function createdConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'created_by');
    }

    /**
     * Quan hệ với Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Quan hệ Department mà user là department head
     */
    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'department_head_id');
    }

     public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_users', 'user_id', 'project_id')
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }

    /**
     * Quan hệ với Project (User quản lý dự án)
     */
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'manager_id');
    }


    /**
 * Quan hệ với Task (User được giao nhiều công việc)
 */
public function tasks()
{
    return $this->hasMany(Task::class, 'user_id');
}

/**
 * Quan hệ với Task đang thực hiện
 */
public function inProgressTasks()
{
    return $this->tasks()->where('status', Task::STATUS_IN_PROGRESS);
}

/**
 * Quan hệ với Task cần xem xét
 */
public function needsReviewTasks()
{
    return $this->tasks()->where('status', Task::STATUS_NEEDS_REVIEW);
}

/**
 * Quan hệ với Task đã hoàn thành
 */
public function completedTasks()
{
    return $this->tasks()->where('status', Task::STATUS_COMPLETED);
}

/**
 * Lấy tasks quá hạn của user
 */
public function overdueTasks()
{
    return $this->tasks()
        ->where('end_date', '<', now())
        ->where('status', '!=', Task::STATUS_COMPLETED);
}

/**
 * Tính tỷ lệ hoàn thành công việc của user
 */
public function getTaskCompletionRateAttribute()
{
    $totalTasks = $this->tasks()->count();
    if ($totalTasks === 0) {
        return 0;
    }

    $completedTasks = $this->completedTasks()->count();
    return round(($completedTasks / $totalTasks) * 100, 2);
}

/**
 * Lấy số lượng task theo trạng thái
 */
public function getTaskCountByStatus($status = null)
{
    if ($status) {
        return $this->tasks()->where('status', $status)->count();
    }

    return [
        'total' => $this->tasks()->count(),
        'in_progress' => $this->inProgressTasks()->count(),
        'needs_review' => $this->needsReviewTasks()->count(),
        'completed' => $this->completedTasks()->count(),
        'overdue' => $this->overdueTasks()->count(),
    ];
}

/**
 * Kiểm tra user có task nào quá hạn không
 */
public function hasOverdueTasks()
{
    return $this->overdueTasks()->exists();
}
public function isDepartmentHead()
{
    return $this->managedDepartments()->exists();
}

/**
 * Lấy department mà user đang quản lý (sửa lỗi typo)
 */
public function managedDepartment()
{
    return $this->hasOne(Department::class, 'department_head_id');
}
public function notifications()
{
    return $this->hasMany(Notification::class)->orderByDesc('created_at');
}

/**
 * Quan hệ với Notifications (người gửi)
 */
public function sentNotifications()
{
    return $this->hasMany(Notification::class, 'from_user_id');
}

/**
 * Lấy thông báo chưa đọc
 */
public function unreadNotifications()
{
    return $this->notifications()->where('is_read', false);
}

/**
 * Đếm số thông báo chưa đọc
 */
public function getUnreadNotificationsCountAttribute()
{
    return $this->unreadNotifications()->count();
}
protected $appends = ['unread_notifications_count'];
}
