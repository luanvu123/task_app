<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salaryslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'user_id',
        'earnings',
        'earnings_amount',
        'deductions',
        'deductions_amount',
        'net_salary',
        'salary_date',
        'status'
    ];

    protected $casts = [
        'earnings_amount' => 'decimal:2',
        'deductions_amount' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'salary_date' => 'date'
    ];

    /**
     * Relationship với User (nhân viên nhận lương)
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship với User (người tạo)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get earnings as array
     */
    public function getEarningsArrayAttribute(): array
    {
        return json_decode($this->earnings, true) ?? [];
    }

    /**
     * Get deductions as array
     */
    public function getDeductionsArrayAttribute(): array
    {
        return json_decode($this->deductions, true) ?? [];
    }

    /**
     * Format currency to VND
     */
    public function formatCurrency($amount): string
    {
        return number_format($amount, 0, ',', '.') . ' VND';
    }

    /**
     * Get formatted earnings amount
     */
    public function getFormattedEarningsAmountAttribute(): string
    {
        return $this->formatCurrency($this->earnings_amount);
    }

    /**
     * Get formatted deductions amount
     */
    public function getFormattedDeductionsAmountAttribute(): string
    {
        return $this->formatCurrency($this->deductions_amount);
    }

    /**
     * Get formatted net salary
     */
    public function getFormattedNetSalaryAttribute(): string
    {
        return $this->formatCurrency($this->net_salary);
    }

    /**
     * Calculate net salary
     */
    public function calculateNetSalary(): void
    {
        $this->net_salary = $this->earnings_amount - $this->deductions_amount;
    }
}
