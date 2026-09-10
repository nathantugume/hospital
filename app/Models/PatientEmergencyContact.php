<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PatientEmergencyContact extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'patient_emergency_contacts';

    protected $fillable = [
        'patient_id', 'name', 'relationship', 'phone', 'email'
    ];

    protected $casts = [
        'phone' => 'encrypted',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('patient_emergency_contacts');
    }
}
