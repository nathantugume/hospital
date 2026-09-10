<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AmbulanceCall extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ambulance_calls';

    protected $fillable = [
        'code', 'ambulance_id', 'caller_name', 'patient_name', 'pickup_location', 'destination', 'call_time', 'dispatch_time', 'arrival_time', 'status', 'priority', 'severity', 'pickup_lat', 'pickup_lng', 'current_lat', 'current_lng', 'driver_id', 'dispatcher_id', 'notes'
    ];

    protected $casts = [
        'call_time' => 'datetime',
        'dispatch_time' => 'datetime',
        'arrival_time' => 'datetime',
        'pickup_lat' => 'decimal:7',
        'pickup_lng' => 'decimal:7',
        'current_lat' => 'decimal:7',
        'current_lng' => 'decimal:7',
    ];

    // Relationships
    public function ambulance(): BelongsTo { return $this->belongsTo(Ambulance::class); }
    public function driver(): BelongsTo { return $this->belongsTo(Staff::class, 'driver_id'); }
    public function dispatcher(): BelongsTo { return $this->belongsTo(Staff::class, 'dispatcher_id'); }
    public function gpsPositions(): HasMany { return $this->hasMany(AmbulanceGpsPosition::class, 'ambulance_call_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('ambulance_calls');
    }
}
