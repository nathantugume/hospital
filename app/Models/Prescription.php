<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Prescription extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'prescriptions';

    protected $fillable = [
        'code', 'patient_id', 'doctor_id', 'date', 'status', 'refills', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'refills' => 'integer',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }
    public function items(): HasMany { return $this->hasMany(PrescriptionItem::class, 'prescription_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('prescriptions');
    }
}
