<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PatientConsent extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'patient_consents';

    protected $fillable = [
        'patient_id', 'consent_type', 'consent_status', 'signed_at', 'signature_data'
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('patient_consents');
    }
}
