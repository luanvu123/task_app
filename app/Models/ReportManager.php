<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReportManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'report_type',
        'department_id',
        'reporter_id',
        'recipient_id',
        'status',
        'priority',
        'report_period_start',
        'report_period_end',
        'submitted_at',
        'reviewed_at',
        'feedback',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
        'report_period_start' => 'date',
        'report_period_end' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Quan hệ với Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Quan hệ với User (Người gửi báo cáo - Trưởng phòng)
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Quan hệ với User (Người nhận báo cáo - Giám đốc)
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Scope: Lấy báo cáo theo phòng ban
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope: Lấy báo cáo theo người gửi
     */
    public function scopeByReporter($query, $reporterId)
    {
        return $query->where('reporter_id', $reporterId);
    }

    /**
     * Scope: Lấy báo cáo theo người nhận
     */
    public function scopeByRecipient($query, $recipientId)
    {
        return $query->where('recipient_id', $recipientId);
    }

    /**
     * Scope: Lấy báo cáo theo trạng thái
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Lấy báo cáo theo loại
     */
    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    /**
     * Scope: Lấy báo cáo theo mức độ ưu tiên
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope: Lấy báo cáo trong khoảng thời gian
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope: Lấy báo cáo chưa được xem
     */
    public function scopeUnreviewed($query)
    {
        return $query->whereIn('status', ['submitted']);
    }

    /**
     * Scope: Lấy báo cáo đã được phê duyệt
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Lấy báo cáo bị từ chối
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope: Lấy báo cáo khẩn cấp
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    /**
     * Kiểm tra xem báo cáo có thể chỉnh sửa không
     */
    public function canBeEdited()
    {
        return in_array($this->status, ['draft']);
    }

    /**
     * Kiểm tra xem báo cáo có thể gửi không
     */
    public function canBeSubmitted()
    {
        return $this->status === 'draft';
    }

    /**
     * Gửi báo cáo
     */
    public function submit()
    {
        if ($this->canBeSubmitted()) {
            $this->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);
            return true;
        }
        return false;
    }

    /**
     * Đánh dấu báo cáo đã được xem
     */
    public function markAsReviewed()
    {
        if ($this->status === 'submitted') {
            $this->update([
                'status' => 'reviewed',
                'reviewed_at' => now(),
            ]);
            return true;
        }
        return false;
    }

    /**
     * Phê duyệt báo cáo
     */
    public function approve($feedback = null)
    {
        if (in_array($this->status, ['submitted', 'reviewed'])) {
            $this->update([
                'status' => 'approved',
                'feedback' => $feedback,
                'reviewed_at' => $this->reviewed_at ?: now(),
            ]);
            return true;
        }
        return false;
    }

    /**
     * Từ chối báo cáo
     */
    public function reject($feedback)
    {
        if (in_array($this->status, ['submitted', 'reviewed'])) {
            $this->update([
                'status' => 'rejected',
                'feedback' => $feedback,
                'reviewed_at' => $this->reviewed_at ?: now(),
            ]);
            return true;
        }
        return false;
    }

    /**
     * Lấy màu sắc theo trạng thái
     */
   public function getStatusColorAttribute()
{
    return match($this->status) {
        'draft' => 'secondary', // xám
        'submitted' => 'primary', // xanh dương
        'reviewed' => 'warning', // vàng
        'approved' => 'success', // xanh lá
        'rejected' => 'danger', // đỏ
        default => 'secondary'
    };
}

public function getPriorityColorAttribute()
{
    return match($this->priority) {
        'low' => 'success',   // xanh lá
        'medium' => 'warning', // vàng
        'high' => 'primary',   // xanh dương (hoặc danger nếu muốn đỏ đậm)
        'urgent' => 'danger',  // đỏ
        default => 'secondary'
    };
}


    /**
     * Lấy label hiển thị cho trạng thái
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Bản nháp',
            'submitted' => 'Đã gửi',
            'reviewed' => 'Đã xem',
            'approved' => 'Đã phê duyệt',
            'rejected' => 'Từ chối',
            default => ucfirst($this->status)
        };
    }

    /**
     * Lấy label hiển thị cho loại báo cáo
     */
    public function getReportTypeLabelAttribute()
    {
        return match($this->report_type) {
            'monthly' => 'Báo cáo tháng',
            'quarterly' => 'Báo cáo quý',
            'yearly' => 'Báo cáo năm',
            'project_completion' => 'Báo cáo hoàn thành dự án',
            'urgent' => 'Báo cáo khẩn cấp',
            'other' => 'Báo cáo khác',
            default => ucfirst($this->report_type)
        };
    }

    /**
     * Lấy thời gian từ lúc gửi báo cáo
     */
    public function getTimeSinceSubmittedAttribute()
    {
        if (!$this->submitted_at) {
            return null;
        }
        return $this->submitted_at->diffForHumans();
    }

    /**
     * Kiểm tra báo cáo có quá hạn không (dựa trên mức độ ưu tiên)
     */
    public function isOverdue()
    {
        if (!$this->submitted_at || in_array($this->status, ['approved', 'rejected'])) {
            return false;
        }

        $hours = match($this->priority) {
            'urgent' => 2,
            'high' => 24,
            'medium' => 72,
            'low' => 168,
            default => 72
        };

        return $this->submitted_at->addHours($hours) < now();
    }
}
