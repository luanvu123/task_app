<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Propose extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'proposed_by',
        'department_id',
        'propose_code',
        'title',
        'description',
        'justification',
        'expected_benefit',
        'total_amount',
        'approved_amount',
        'currency',
        'budget_source',
        'propose_type',
        'priority',
        'is_urgent',
        'needed_by_date',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_comments',
        'approved_by',
        'approved_at',
        'approval_comments',
        'vendor_id',
        'quotations',
        'expected_delivery_date',
        'actual_delivery_date',
        'payment_method',
        'payment_status',
        'attachments',
        'quotation_files',
        'approval_documents',
        'implementation_notes',
        'completion_percentage',
        'completion_date',
        'satisfaction_rating',
        'feedback',
        'would_recommend_vendor'
    ];

    protected $casts = [
        'quotations' => 'array',
        'attachments' => 'array',
        'quotation_files' => 'array',
        'approval_documents' => 'array',
        'needed_by_date' => 'date',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'completion_date' => 'date',
        'is_urgent' => 'boolean',
        'would_recommend_vendor' => 'boolean',
        'total_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
    ];

    // Constants for enums
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_PENDING_APPROVAL = 'pending_approval';
    const STATUS_APPROVED = 'approved';
    const STATUS_PARTIALLY_APPROVED = 'partially_approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    const TYPE_EQUIPMENT = 'equipment';
    const TYPE_SUPPLIES = 'supplies';
    const TYPE_SERVICES = 'services';
    const TYPE_SOFTWARE = 'software';
    const TYPE_TRAINING = 'training';
    const TYPE_TRAVEL = 'travel';
    const TYPE_OTHER = 'other';

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function proposedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProposeItem::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    // Accessor & Mutator
    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_DRAFT => 'secondary',
            self::STATUS_SUBMITTED => 'info',
            self::STATUS_UNDER_REVIEW => 'warning',
            self::STATUS_PENDING_APPROVAL => 'primary',
            self::STATUS_APPROVED => 'success',
            self::STATUS_PARTIALLY_APPROVED => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_CANCELLED => 'dark',
            self::STATUS_COMPLETED => 'success',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            self::PRIORITY_LOW => 'info',
            self::PRIORITY_MEDIUM => 'warning',
            self::PRIORITY_HIGH => 'danger',
            self::PRIORITY_URGENT => 'danger',
        ];

        return $badges[$this->priority] ?? 'info';
    }

    // Helper methods
    public function canBeEdited(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_SUBMITTED]);
    }

    public function canBeApproved(): bool
    {
        return $this->status === self::STATUS_PENDING_APPROVAL;
    }

    public function isApproved(): bool
    {
        return in_array($this->status, [self::STATUS_APPROVED, self::STATUS_PARTIALLY_APPROVED]);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function calculateTotalAmount(): void
    {
        $this->total_amount = $this->items()->sum('final_amount');
        $this->save();
    }

    public function generateProposeCode(): string
    {
        $prefix = 'PR';
        $year = date('Y');
        $month = date('m');

        $lastPropose = static::where('propose_code', 'like', "{$prefix}-{$year}{$month}%")
            ->orderBy('propose_code', 'desc')
            ->first();

        if ($lastPropose) {
            $lastNumber = (int) substr($lastPropose->propose_code, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}-{$year}{$month}-{$newNumber}";
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($propose) {
            if (empty($propose->propose_code)) {
                $propose->propose_code = $propose->generateProposeCode();
            }
        });
    }
    // Add this method to your Propose model class

public function getStatusText(): string
{
    $statusTexts = [
        self::STATUS_DRAFT => 'Bản nháp',
        self::STATUS_SUBMITTED => 'Đã gửi',
        self::STATUS_UNDER_REVIEW => 'Đang xem xét',
        self::STATUS_PENDING_APPROVAL => 'Chờ phê duyệt',
        self::STATUS_APPROVED => 'Đã phê duyệt',
        self::STATUS_PARTIALLY_APPROVED => 'Phê duyệt một phần',
        self::STATUS_REJECTED => 'Từ chối',
        self::STATUS_CANCELLED => 'Đã hủy',
        self::STATUS_COMPLETED => 'Hoàn thành',
    ];

    return $statusTexts[$this->status] ?? 'Không xác định';
}
}
