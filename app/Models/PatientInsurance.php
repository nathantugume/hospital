<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PatientInsurance extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'patient_insurances';

    protected $fillable = [
        'patient_id', 'is_primary', 'provider', 'policy_number', 'group_number', 'policy_holder', 'relationship', 'provider_phone', 'verification_status'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('patient_insurances');
    }
}
