<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PhysiotherapySession extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'physiotherapy_sessions';

    protected $fillable = [
        'date', 'time', 'patient_id', 'therapist_id', 'type', 'room', 'duration', 'condition', 'status', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetimeHi',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function therapist(): BelongsTo { return $this->belongsTo(Staff::class, 'therapist_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('physiotherapy_sessions');
    }
}
