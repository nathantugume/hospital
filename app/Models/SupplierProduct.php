<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SupplierProduct extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'supplier_products';

    protected $fillable = [
        'code', 'supplier_id', 'name', 'category', 'price', 'currency', 'lead_time', 'min_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('supplier_products');
    }
}
