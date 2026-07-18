<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PrescriptionItem extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'prescription_items';

    protected $fillable = [
        'prescription_id', 'medication', 'medicine_id', 'dosage', 'frequency', 'route', 'duration', 'duration_unit', 'instructions', 'refills_allowed', 'start_date', 'end_date'
    ];

    protected $casts = [
        'duration' => 'integer',
        'refills_allowed' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class); }
    public function medicine(): BelongsTo { return $this->belongsTo(Medicine::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('prescription_items');
    }
}
