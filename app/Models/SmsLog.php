<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SmsLog extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'sms_logs';

    protected $fillable = [
        'message_id', 'to_phone', 'recipient_name', 'message', 'sender_id', 'provider', 'status', 'status_code', 'cost', 'currency', 'category', 'user_id', 'patient_id', 'staff_id', 'error_message', 'sent_at', 'delivered_at'
    ];

    protected $casts = [
        'cost' => 'decimal:4',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'to_phone' => 'encrypted',
    ];

    // Relationships
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('sms_logs');
    }
}
