<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProjectTimesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'work_date',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'total_hours',
        'status',
        'notes',
        'submitted_at',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'work_date' => 'date',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'total_hours' => 'decimal:2'
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Quan hệ với Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Quan hệ với User (người tạo timesheet)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với User (người approve)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Tự động tính tổng giờ khi save
     */
    protected static function booted()
    {
        static::saving(function ($timesheet) {
            $timesheet->calculateTotalHours();
        });
    }

    /**
     * Tính tổng số giờ làm việc trong tuần
     */
    public function calculateTotalHours()
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $totalMinutes = 0;

        foreach ($days as $day) {
            if ($this->$day && $this->$day !== '00:00:00') {
                $time = explode(':', $this->$day);
                $minutes = ($time[0] * 60) + $time[1] + ($time[2] / 60);
                $totalMinutes += $minutes;
            }
        }

        $this->total_hours = round($totalMinutes / 60, 2);
    }

    /**
     * Lấy tổng giờ theo định dạng giờ:phút
     */
    public function getFormattedTotalHoursAttribute()
    {
        $totalMinutes = $this->total_hours * 60;
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    /**
     * Scope để lọc theo tuần
     */
    public function scopeForWeek($query, $startDate)
    {
        $endDate = Carbon::parse($startDate)->addDays(6);
        return $query->whereBetween('work_date', [$startDate, $endDate]);
    }

    /**
     * Scope để lọc theo tháng
     */
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('work_date', $year)
                    ->whereMonth('work_date', $month);
    }

    /**
     * Scope để lọc theo status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Kiểm tra xem có thể edit không
     */
    public function canEdit()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Kiểm tra xem có thể submit không
     */
    public function canSubmit()
    {
        return $this->status === self::STATUS_DRAFT && $this->total_hours > 0;
    }

    /**
     * Submit timesheet
     */
    public function submit()
    {
        if ($this->canSubmit()) {
            $this->update([
                'status' => self::STATUS_SUBMITTED,
                'submitted_at' => now()
            ]);
            return true;
        }
        return false;
    }

    /**
     * Approve timesheet
     */
    public function approve($approvedBy)
    {
        if ($this->status === self::STATUS_SUBMITTED) {
            $this->update([
                'status' => self::STATUS_APPROVED,
                'approved_at' => now(),
                'approved_by' => $approvedBy
            ]);
            return true;
        }
        return false;
    }

    /**
     * Reject timesheet
     */
    public function reject()
    {
        if ($this->status === self::STATUS_SUBMITTED) {
            $this->update([
                'status' => self::STATUS_REJECTED,
                'approved_at' => null,
                'approved_by' => null
            ]);
            return true;
        }
        return false;
    }

    /**
     * Lấy danh sách tất cả statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Nháp',
            self::STATUS_SUBMITTED => 'Đã gửi',
            self::STATUS_APPROVED => 'Đã duyệt',
            self::STATUS_REJECTED => 'Từ chối'
        ];
    }
}
