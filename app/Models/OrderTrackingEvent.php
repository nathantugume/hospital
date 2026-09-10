<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OrderTrackingEvent extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'order_tracking_events';

    protected $fillable = [
        'purchase_order_id', 'date', 'location', 'status', 'description'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Relationships
    public function purchaseOrder(): BelongsTo { return $this->belongsTo(PurchaseOrder::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('order_tracking_events');
    }
}
