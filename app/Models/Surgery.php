<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Surgery extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'surgeries';

    protected $fillable = [
        'code', 'patient_id', 'procedure', 'ot_room', 'room_name', 'surgeon_id', 'anesthesiologist_id', 'nurse_id', 'date', 'start_time', 'end_time', 'status', 'priority', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetimeHi',
        'end_time' => 'datetimeHi',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function surgeon(): BelongsTo { return $this->belongsTo(Staff::class, 'surgeon_id'); }
    public function anesthesiologist(): BelongsTo { return $this->belongsTo(Staff::class, 'anesthesiologist_id'); }
    public function nurse(): BelongsTo { return $this->belongsTo(Staff::class, 'nurse_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('surgeries');
    }
}
