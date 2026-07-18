<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DeathRecord extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'death_records';

    protected $fillable = [
        'code', 'patient_id', 'name', 'age', 'date_of_death', 'time_of_death', 'cause', 'doctor_id', 'doctor_name', 'location', 'status'
    ];

    protected $casts = [
        'age' => 'integer',
        'date_of_death' => 'date',
        'time_of_death' => 'datetimeHi',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('death_records');
    }
}
