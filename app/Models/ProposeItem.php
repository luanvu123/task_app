<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'propose_id',
        'item_code',
        'name',
        'description',
        'specifications',
        'brand',
        'model',
        'category_id',
        'unit',
        'quantity',
        'unit_price',
        'total_price',
        'discount_percent',
        'discount_amount',
        'tax_percent',
        'tax_amount',
        'final_amount',
        'approval_status',
        'approved_quantity',
        'approved_unit_price',
        'rejection_reason',
        'preferred_vendor_id',
        'vendor_quotes',
        'needed_by_date',
        'priority',
        'is_essential',
        'quality_requirements',
        'technical_requirements',
        'certifications_required',
        'warranty_period',
        'procurement_status',
        'expected_delivery_date',
        'actual_delivery_date',
        'delivered_quantity',
        'delivery_notes',
        'attachments',
        'quotation_files',
        'quality_rating',
        'delivery_rating',
        'feedback',
        'warranty_start_date',
        'warranty_end_date',
        'maintenance_notes'
    ];

    protected $casts = [
        'vendor_quotes' => 'array',
        'certifications_required' => 'array',
        'attachments' => 'array',
        'quotation_files' => 'array',
        'needed_by_date' => 'date',
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'warranty_start_date' => 'date',
        'warranty_end_date' => 'date',
        'is_essential' => 'boolean',
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_percent' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'approved_quantity' => 'decimal:2',
        'approved_unit_price' => 'decimal:2',
        'delivered_quantity' => 'decimal:2',
    ];

    // Constants for enums
    const APPROVAL_STATUS_PENDING = 'pending';
    const APPROVAL_STATUS_APPROVED = 'approved';
    const APPROVAL_STATUS_REJECTED = 'rejected';
    const APPROVAL_STATUS_MODIFIED = 'modified';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_CRITICAL = 'critical';

    const PROCUREMENT_NOT_STARTED = 'not_started';
    const PROCUREMENT_QUOTATION_REQUESTED = 'quotation_requested';
    const PROCUREMENT_QUOTATION_RECEIVED = 'quotation_received';
    const PROCUREMENT_VENDOR_SELECTED = 'vendor_selected';
    const PROCUREMENT_ORDER_PLACED = 'order_placed';
    const PROCUREMENT_IN_TRANSIT = 'in_transit';
    const PROCUREMENT_DELIVERED = 'delivered';
    const PROCUREMENT_COMPLETED = 'completed';
    const PROCUREMENT_CANCELLED = 'cancelled';

    // Relationships
    public function propose(): BelongsTo
    {
        return $this->belongsTo(Propose::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    public function preferredVendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'preferred_vendor_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('approval_status', self::APPROVAL_STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', self::APPROVAL_STATUS_PENDING);
    }

    public function scopeEssential($query)
    {
        return $query->where('is_essential', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByProcurementStatus($query, $status)
    {
        return $query->where('procurement_status', $status);
    }

    // Accessor & Mutator
    public function getApprovalStatusBadgeAttribute()
    {
        $badges = [
            self::APPROVAL_STATUS_PENDING => 'warning',
            self::APPROVAL_STATUS_APPROVED => 'success',
            self::APPROVAL_STATUS_REJECTED => 'danger',
            self::APPROVAL_STATUS_MODIFIED => 'info',
        ];

        return $badges[$this->approval_status] ?? 'secondary';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            self::PRIORITY_LOW => 'info',
            self::PRIORITY_MEDIUM => 'warning',
            self::PRIORITY_HIGH => 'danger',
            self::PRIORITY_CRITICAL => 'danger',
        ];

        return $badges[$this->priority] ?? 'info';
    }

    public function getProcurementStatusBadgeAttribute()
    {
        $badges = [
            self::PROCUREMENT_NOT_STARTED => 'secondary',
            self::PROCUREMENT_QUOTATION_REQUESTED => 'info',
            self::PROCUREMENT_QUOTATION_RECEIVED => 'primary',
            self::PROCUREMENT_VENDOR_SELECTED => 'warning',
            self::PROCUREMENT_ORDER_PLACED => 'warning',
            self::PROCUREMENT_IN_TRANSIT => 'info',
            self::PROCUREMENT_DELIVERED => 'success',
            self::PROCUREMENT_COMPLETED => 'success',
            self::PROCUREMENT_CANCELLED => 'danger',
        ];

        return $badges[$this->procurement_status] ?? 'secondary';
    }

    // Helper methods
    public function calculateTotals(): void
    {
        $this->total_price = $this->quantity * $this->unit_price;

        // Tính chiết khấu
        if ($this->discount_percent > 0) {
            $this->discount_amount = $this->total_price * ($this->discount_percent / 100);
        }

        $subtotal = $this->total_price - $this->discount_amount;

        // Tính thuế
        $this->tax_amount = $subtotal * ($this->tax_percent / 100);

        // Tổng cuối cùng
        $this->final_amount = $subtotal + $this->tax_amount;
    }

    public function isApproved(): bool
    {
        return $this->approval_status === self::APPROVAL_STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->approval_status === self::APPROVAL_STATUS_REJECTED;
    }

    public function canBeEdited(): bool
    {
        return in_array($this->approval_status, [
            self::APPROVAL_STATUS_PENDING,
            self::APPROVAL_STATUS_MODIFIED
        ]);
    }

    public function isDelivered(): bool
    {
        return in_array($this->procurement_status, [
            self::PROCUREMENT_DELIVERED,
            self::PROCUREMENT_COMPLETED
        ]);
    }

    public function getDeliveryProgress(): int
    {
        if (!$this->delivered_quantity || !$this->quantity) {
            return 0;
        }

        return min(100, ($this->delivered_quantity / $this->quantity) * 100);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->calculateTotals();
        });

        static::saved(function ($item) {
            // Cập nhật tổng tiền của đề xuất
            $item->propose->calculateTotalAmount();
        });
    }
    
}
