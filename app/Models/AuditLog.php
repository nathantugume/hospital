<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AuditLog extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'audit_logs';

    protected $fillable = [
        'timestamp', 'user_id', 'user_name', 'action', 'entity', 'entity_id', 'department', 'ip_address', 'old_values', 'new_values'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('audit_logs');
    }
}
