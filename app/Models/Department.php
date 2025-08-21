<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_head_id',
        'status',
    ];

    /**
     * Quan hệ với User (Department Head)
     */
    public function departmentHead()
    {
        return $this->belongsTo(User::class, 'department_head_id');
    }

    /**
     * Quan hệ với User (Employees in department)
     */
    public function employees()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    /**
     * Đếm số lượng nhân viên trong phòng ban
     */
    public function getEmployeeCountAttribute()
    {
        return $this->employees()->count();
    }

    /**
     * Quan hệ với Project (Department có nhiều dự án)
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'department_id');
    }

    /**
     * Đếm số lượng dự án trong phòng ban
     */
    public function getProjectCountAttribute()
    {
        return $this->projects()->count();
    }

    /**
     * Quan hệ với ReportManager (Department có nhiều báo cáo)
     */
    public function reports()
    {
        return $this->hasMany(ReportManager::class, 'department_id');
    }

    /**
     * Lấy báo cáo do trưởng phòng gửi
     */
    public function reportsFromHead()
    {
        return $this->hasMany(ReportManager::class, 'department_id')
                   ->where('reporter_id', $this->department_head_id);
    }

    /**
     * Đếm số lượng báo cáo của phòng ban
     */
    public function getReportCountAttribute()
    {
        return $this->reports()->count();
    }

    /**
     * Đếm báo cáo chưa được xem
     */
    public function getPendingReportCountAttribute()
    {
        return $this->reports()->whereIn('status', ['submitted'])->count();
    }

    /**
     * Đếm báo cáo đã được phê duyệt
     */
    public function getApprovedReportCountAttribute()
    {
        return $this->reports()->where('status', 'approved')->count();
    }

    /**
     * Lấy báo cáo mới nhất của phòng ban
     */
    public function getLatestReportAttribute()
    {
        return $this->reports()->latest('created_at')->first();
    }

    /**
     * Lấy báo cáo khẩn cấp
     */
    public function getUrgentReportsAttribute()
    {
        return $this->reports()->where('priority', 'urgent')
                   ->whereIn('status', ['submitted', 'reviewed'])
                   ->get();
    }

    /**
     * Scope: Lấy phòng ban có báo cáo chưa xử lý
     */
    public function scopeWithPendingReports($query)
    {
        return $query->whereHas('reports', function($q) {
            $q->whereIn('status', ['submitted']);
        });
    }

    /**
     * Kiểm tra phòng ban có báo cáo quá hạn không
     */
    public function hasOverdueReports()
    {
        return $this->reports()->get()->contains(function($report) {
            return $report->isOverdue();
        });
    }

    /**
     * Lấy thống kê báo cáo theo tháng
     */
    public function getMonthlyReportStats($year = null, $month = null)
    {
        $year = $year ?: now()->year;
        $month = $month ?: now()->month;

        return $this->reports()
                   ->whereYear('created_at', $year)
                   ->whereMonth('created_at', $month)
                   ->selectRaw('
                       status,
                       COUNT(*) as count,
                       priority
                   ')
                   ->groupBy('status', 'priority')
                   ->get();
    }
}
