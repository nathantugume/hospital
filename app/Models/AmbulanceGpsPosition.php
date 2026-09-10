<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AmbulanceGpsPosition extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ambulance_gps_positions';

    protected $fillable = [
        'ambulance_id', 'ambulance_call_id', 'lat', 'lng', 'speed', 'heading', 'recorded_at'
    ];

    protected $casts = [
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
        'speed' => 'decimal:2',
        'heading' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    // Relationships
    public function ambulance(): BelongsTo { return $this->belongsTo(Ambulance::class); }
    public function call(): BelongsTo { return $this->belongsTo(AmbulanceCall::class, 'ambulance_call_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('ambulance_gps_positions');
    }
}
