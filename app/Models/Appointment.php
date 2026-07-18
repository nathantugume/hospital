<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Appointment extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'appointments';

    protected $fillable = [
        'company_id', 'patient_id', 'doctor_id', 'department_id', 'service_id', 'date', 'start_time', 'end_time', 'time_label', 'duration', 'type', 'status', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('appointments');
    }
}
