<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ChatMessage extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'chat_messages';

    protected $fillable = [
        'thread_id', 'sender_id', 'sender', 'text', 'sent_at', 'read'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'read' => 'boolean',
    ];

    // Relationships
    public function thread(): BelongsTo { return $this->belongsTo(ChatThread::class); }
    public function senderUser(): BelongsTo { return $this->belongsTo(User::class, 'sender_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('chat_messages');
    }
}
