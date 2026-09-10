<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RoomAllotment extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'room_allotments';

    protected $fillable = [
        'code', 'patient_id', 'room_id', 'room_number', 'room_type', 'department_id', 'allotment_date', 'discharge_date', 'status', 'doctor_id', 'daily_rate', 'currency', 'insurance_verified'
    ];

    protected $casts = [
        'allotment_date' => 'date',
        'discharge_date' => 'date',
        'daily_rate' => 'decimal:2',
        'insurance_verified' => 'boolean',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function room(): BelongsTo { return $this->belongsTo(Room::class); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('room_allotments');
    }
}
