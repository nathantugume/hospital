<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ChatThread extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'chat_threads';

    protected $fillable = [
        'user_id', 'name', 'role', 'avatar', 'unread_count', 'last_message', 'last_message_at', 'status', 'is_group', 'is_blocked'
    ];

    protected $casts = [
        'unread_count' => 'integer',
        'last_message_at' => 'datetime',
        'is_group' => 'boolean',
        'is_blocked' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function messages(): HasMany { return $this->hasMany(ChatMessage::class, 'thread_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('chat_threads');
    }
}
