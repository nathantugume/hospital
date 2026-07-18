<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InventoryTransferDispatch extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'inventory_transfer_dispatches';

    protected $fillable = [
        'transfer_id', 'dispatched_by', 'dispatch_date', 'transport_method', 'estimated_delivery', 'tracking_number', 'packed_by', 'dispatch_notes', 'urgent_dispatch', 'notify_receiver', 'total_items', 'total_qty', 'status', 'dispatched_at'
    ];

    protected $casts = [
        'dispatch_date' => 'date',
        'estimated_delivery' => 'date',
        'urgent_dispatch' => 'boolean',
        'notify_receiver' => 'boolean',
        'total_items' => 'integer',
        'total_qty' => 'integer',
        'dispatched_at' => 'datetime',
    ];

    // Relationships
    public function transfer(): BelongsTo { return $this->belongsTo(InventoryTransfer::class); }
    public function dispatchedBy(): BelongsTo { return $this->belongsTo(Staff::class, 'dispatched_by'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('inventory_transfer_dispatches');
    }
}
