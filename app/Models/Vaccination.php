<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Vaccination extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'vaccinations';

    protected $fillable = [
        'code', 'patient_id', 'vaccine_name', 'dose', 'date', 'administered_by', 'status', 'next_dose_date', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'next_dose_date' => 'date',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function administeredBy(): BelongsTo { return $this->belongsTo(Staff::class, 'administered_by'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('vaccinations');
    }
}
