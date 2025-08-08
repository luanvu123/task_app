<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'content',
        'type',
        'attachments',
        'reply_to',
        'is_edited',
        'edited_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime'
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'reply_to');
    }

    /**
     * Lấy tin nhắn đã được format
     */
    public function getFormattedContentAttribute()
    {
        if ($this->type === 'system') {
            return $this->content;
        }

        return nl2br(e($this->content));
    }

    /**
     * Kiểm tra tin nhắn có phải của user hiện tại không
     */
    public function isMine($userId)
    {
        return $this->user_id == $userId;
    }

    /**
     * Lấy thời gian hiển thị
     */
    public function getTimeDisplayAttribute()
    {
        return $this->created_at->format('H:i');
    }
}

