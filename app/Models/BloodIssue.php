<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BloodIssue extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'blood_issues';

    protected $fillable = [
        'code', 'recipient', 'recipient_type', 'patient_id', 'blood_type', 'units', 'date', 'doctor_id', 'doctor_name', 'purpose', 'status', 'emergency', 'department'
    ];

    protected $casts = [
        'units' => 'integer',
        'date' => 'date',
        'emergency' => 'boolean',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('blood_issues');
    }
}
