<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RadiologyOrder extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'radiology_orders';

    protected $fillable = [
        'code', 'patient_id', 'modality', 'body_part', 'priority', 'status', 'referring_doctor_id', 'radiologist_id', 'order_date', 'scheduled_date', 'completed_date', 'room', 'report_status', 'report_findings', 'attachment_url'
    ];

    protected $casts = [
        'order_date' => 'date',
        'scheduled_date' => 'date',
        'completed_date' => 'date',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function referringDoctor(): BelongsTo { return $this->belongsTo(Staff::class, 'referring_doctor_id'); }
    public function radiologist(): BelongsTo { return $this->belongsTo(Staff::class, 'radiologist_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('radiology_orders');
    }
}
