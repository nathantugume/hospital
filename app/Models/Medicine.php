<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Medicine extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'medicines';

    protected $fillable = [
        'code', 'name', 'generic_name', 'category', 'type', 'manufacturer', 'selling_price', 'currency', 'stock', 'reorder_level', 'expiry', 'status', 'barcode'
    ];

    protected $casts = [
        'selling_price' => 'decimal:2',
        'stock' => 'integer',
        'reorder_level' => 'integer',
        'expiry' => 'date',
    ];

    // Relationships
    public function batches(): HasMany { return $this->hasMany(MedicineBatch::class, 'medicine_id'); }
    public function transactions(): HasMany { return $this->hasMany(MedicineTransaction::class, 'medicine_id'); }
    public function prescriptionItems(): HasMany { return $this->hasMany(PrescriptionItem::class, 'medicine_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('medicines');
    }
}
