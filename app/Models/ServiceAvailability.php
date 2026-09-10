<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ServiceAvailability extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'service_availability';

    protected $fillable = [
        'service_id', 'day_of_week', 'slots'
    ];

    protected $casts = [
        // none
    ];

    // Relationships
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('service_availability');
    }
}
