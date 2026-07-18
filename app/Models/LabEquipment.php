<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LabEquipment extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'lab_equipment';

    protected $fillable = [
        'code', 'name', 'department', 'serial_number', 'last_maintenance', 'next_maintenance', 'status', 'location', 'manufacturer', 'purchase_date', 'purchase_cost', 'warranty_expiry', 'service_provider', 'notes'
    ];

    protected $casts = [
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'purchase_cost' => 'decimal:2',
    ];

    // Relationships
        // none

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('lab_equipment');
    }
}
