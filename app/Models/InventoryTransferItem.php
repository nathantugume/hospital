<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InventoryTransferItem extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'inventory_transfer_items';

    protected $fillable = [
        'transfer_id', 'item_name', 'batch', 'qty', 'unit'
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    // Relationships
    public function transfer(): BelongsTo { return $this->belongsTo(InventoryTransfer::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('inventory_transfer_items');
    }
}
