<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Room extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'rooms';

    protected $fillable = [
        'number', 'type', 'status', 'department_id', 'ward_id', 'capacity', 'equipment', 'patient_id', 'doctor_id'
    ];

    protected $casts = [
        'capacity' => 'integer',
    ];

    // Relationships
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function ward(): BelongsTo { return $this->belongsTo(Ward::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }
    public function allotments(): HasMany { return $this->hasMany(RoomAllotment::class, 'room_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('rooms');
    }
}
