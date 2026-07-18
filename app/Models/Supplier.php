<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Supplier extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'suppliers';

    protected $fillable = [
        'code', 'name', 'category', 'email', 'phone', 'address', 'location', 'rating', 'status', 'preferred', 'delivery_rate', 'lead_time', 'items_count'
    ];

    protected $casts = [
        'rating' => 'integer',
        'items_count' => 'integer',
        'preferred' => 'boolean',
        'phone' => 'encrypted',
    ];

    // Relationships
    public function products(): HasMany { return $this->hasMany(SupplierProduct::class, 'supplier_id'); }
    public function purchaseOrders(): HasMany { return $this->hasMany(PurchaseOrder::class, 'supplier_id'); }
    public function inventoryItems(): HasMany { return $this->hasMany(InventoryItem::class, 'supplier_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('suppliers');
    }
}
