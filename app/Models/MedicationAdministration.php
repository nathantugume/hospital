<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MedicationAdministration extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'medication_administrations';

    protected $fillable = [
        'patient_id', 'medication', 'medicine_id', 'dosage', 'scheduled_time', 'administered_at', 'status', 'administered_by'
    ];

    protected $casts = [
        'scheduled_time' => 'datetimeHi',
        'administered_at' => 'datetime',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function medicine(): BelongsTo { return $this->belongsTo(Medicine::class); }
    public function administeredBy(): BelongsTo { return $this->belongsTo(Staff::class, 'administered_by'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('medication_administrations');
    }
}
