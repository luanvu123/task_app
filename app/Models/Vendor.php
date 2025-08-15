<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'tax_code',
        'status',
        'specialties',
        'rating'
    ];

    protected $casts = [
        'specialties' => 'array',
        'rating' => 'decimal:1'
    ];

    // Scope cho active vendors
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope cho inactive vendors
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Accessor cho status text
    public function getStatusTextAttribute()
    {
        return $this->status === 'active' ? 'Hoạt động' : 'Không hoạt động';
    }

    // Accessor cho specialties text
    public function getSpecialtiesTextAttribute()
    {
        if (!$this->specialties) {
            return 'Chưa có';
        }
        return is_array($this->specialties) ? implode(', ', $this->specialties) : $this->specialties;
    }
}
