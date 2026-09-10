<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PurchaseOrder extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'code', 'supplier_id', 'item', 'quantity', 'unit_price', 'amount', 'currency', 'order_date', 'delivery_date', 'status', 'priority', 'tracking_number', 'carrier'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
        'order_date' => 'date',
        'delivery_date' => 'date',
    ];

    // Relationships
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }
    public function trackingEvents(): HasMany { return $this->hasMany(OrderTrackingEvent::class, 'purchase_order_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('purchase_orders');
    }
}
