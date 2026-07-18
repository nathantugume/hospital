<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ambulance extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ambulances';

    protected $fillable = [
        'code', 'reg_no', 'model', 'year', 'type', 'status', 'driver_id', 'driver_name', 'location', 'last_maintenance', 'next_maintenance', 'mileage', 'fuel_type', 'capacity_stretchers', 'capacity_seated', 'purchase_date', 'insurance_expiry', 'equipment'
    ];

    protected $casts = [
        'year' => 'integer',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'capacity_stretchers' => 'integer',
        'capacity_seated' => 'integer',
        'purchase_date' => 'date',
        'insurance_expiry' => 'date',
    ];

    // Relationships
    public function driver(): BelongsTo { return $this->belongsTo(Staff::class, 'driver_id'); }
    public function calls(): HasMany { return $this->hasMany(AmbulanceCall::class, 'ambulance_id'); }
    public function gpsPositions(): HasMany { return $this->hasMany(AmbulanceGpsPosition::class, 'ambulance_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('ambulances');
    }
}
