<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RoleAssignment extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'role_assignments';

    protected $fillable = [
        'user_id', 'staff_id', 'department_id', 'staff_name', 'email', 'roles', 'assigned_by', 'last_updated', 'status'
    ];

    protected $casts = [
        'last_updated' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('role_assignments');
    }
}
