<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'contact_person',
        'contact_position',
        'tax_code',
        'type',
        'status',
        'description',
        'additional_info',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'additional_info' => 'array',
    ];

    /**
     * Enum values for type
     */
    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_COMPANY = 'company';

    /**
     * Enum values for status
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_POTENTIAL = 'potential';

    /**
     * Quan hệ với Project (Một customer có nhiều dự án)
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Lấy các dự án đang hoạt động của khách hàng
     */
    public function activeProjects()
    {
        return $this->projects()->whereIn('status', [
            Project::STATUS_PLANNING,
            Project::STATUS_IN_PROGRESS
        ]);
    }

    /**
     * Lấy các dự án đã hoàn thành của khách hàng
     */
    public function completedProjects()
    {
        return $this->projects()->where('status', Project::STATUS_COMPLETED);
    }

    /**
     * Scope để lọc theo trạng thái
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope để lọc theo loại khách hàng
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope để lọc khách hàng đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Tính tổng ngân sách của tất cả dự án
     */
    public function getTotalProjectBudgetAttribute()
    {
        return $this->projects()->sum('budget');
    }

    /**
     * Đếm số dự án đang hoạt động
     */
    public function getActiveProjectsCountAttribute()
    {
        return $this->activeProjects()->count();
    }

    /**
     * Đếm tổng số dự án
     */
    public function getTotalProjectsCountAttribute()
    {
        return $this->projects()->count();
    }

    /**
     * Kiểm tra xem khách hàng có dự án đang hoạt động không
     */
    public function hasActiveProjects()
    {
        return $this->activeProjects()->exists();
    }

    /**
     * Lấy danh sách tất cả customer types
     */
    public static function getTypes()
    {
        return [
            self::TYPE_INDIVIDUAL => 'Cá nhân',
            self::TYPE_COMPANY => 'Công ty'
        ];
    }

    /**
     * Lấy danh sách tất cả statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Đang hoạt động',
            self::STATUS_INACTIVE => 'Không hoạt động',
            self::STATUS_POTENTIAL => 'Tiềm năng'
        ];
    }

    /**
     * Format tên hiển thị
     */
    public function getDisplayNameAttribute()
    {
        return $this->code . ' - ' . $this->name;
    }

    /**
     * Boot method để tự động generate code nếu chưa có
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (empty($customer->code)) {
                $customer->code = self::generateCustomerCode();
            }
        });
    }

    /**
     * Generate mã khách hàng tự động
     */
    private static function generateCustomerCode()
    {
        $prefix = 'CUS';
        $year = date('Y');
        $lastCustomer = self::whereYear('created_at', $year)
                           ->where('code', 'LIKE', $prefix . $year . '%')
                           ->orderBy('code', 'desc')
                           ->first();

        if ($lastCustomer) {
            $lastNumber = (int) substr($lastCustomer->code, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
