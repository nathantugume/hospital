<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InventoryItem extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'inventory_items';

    protected $fillable = [
        'code', 'name', 'category', 'stock_current', 'min_level', 'max_level', 'reorder_level', 'status', 'unit', 'supplier_id', 'supplier_item_code', 'supplier_price', 'currency', 'lead_time_days', 'min_order_qty', 'last_updated', 'barcode'
    ];

    protected $casts = [
        'stock_current' => 'integer',
        'min_level' => 'integer',
        'reorder_level' => 'integer',
        'supplier_price' => 'decimal:2',
        'last_updated' => 'date',
    ];

    // Relationships
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('inventory_items');
    }
}
