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
}
