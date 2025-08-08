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
        'password' => 'hashed',
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
        return match($this->status) {
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
        return match($this->gender) {
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
        return match($this->marital_status) {
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
}
