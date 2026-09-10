<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RoleChangeLog extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'role_change_log';

    protected $fillable = [
        'user_id', 'changed_by', 'user_name', 'prev_role', 'new_role', 'date'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function changedBy(): BelongsTo { return $this->belongsTo(User::class, 'changed_by'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('role_change_log');
    }
}
