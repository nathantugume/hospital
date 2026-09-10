<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InventoryTransfer extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'inventory_transfers';

    protected $fillable = [
        'code', 'from_location', 'to_location', 'items', 'qty', 'date', 'status', 'requested_by', 'approved_by', 'rejected_by', 'dispatched_by', 'received_by', 'cancelled_by', 'rejection_reason', 'cancel_reason'
    ];

    protected $casts = [
        'date' => 'date',
        'qty' => 'integer',
    ];

    // Relationships
    public function requestedBy(): BelongsTo { return $this->belongsTo(Staff::class, 'requested_by'); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(Staff::class, 'approved_by'); }
    public function dispatchedBy(): BelongsTo { return $this->belongsTo(Staff::class, 'dispatched_by'); }
    public function receivedBy(): BelongsTo { return $this->belongsTo(Staff::class, 'received_by'); }
    public function transferItems(): HasMany { return $this->hasMany(InventoryTransferItem::class, 'transfer_id'); }
    public function dispatches(): HasMany { return $this->hasMany(InventoryTransferDispatch::class, 'transfer_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('inventory_transfers');
    }
}
