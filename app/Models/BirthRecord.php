<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BirthRecord extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'birth_records';

    protected $fillable = [
        'code', 'child_name', 'date_of_birth', 'time_of_birth', 'gender', 'weight', 'parents', 'mother_name', 'father_name', 'patient_id', 'doctor_id', 'doctor_name', 'place_of_birth', 'location', 'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'time_of_birth' => 'datetimeHi',
        'weight' => 'decimal:2',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('birth_records');
    }
}
