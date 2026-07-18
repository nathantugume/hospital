<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ServiceProvider extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'service_providers';

    protected $fillable = [
        'service_id', 'staff_id', 'assigned'
    ];

    protected $casts = [
        'assigned' => 'boolean',
    ];

    // Relationships
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('service_providers');
    }
}
