<?php

namespace App\Models;

use App\Models\Concerns\ScopesToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AppointmentRequest extends Model
{
    use HasFactory, LogsActivity, ScopesToCompany;

    protected $table = 'appointment_requests';

    protected $fillable = [
        'company_id', 'patient_id', 'doctor_id', 'requested_date', 'requested_time', 'type', 'status', 'notes'
    ];

    protected $casts = [
        'requested_date' => 'date',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('appointment_requests');
    }
}
