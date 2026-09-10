<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MedicineTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'medicine_transactions';

    protected $fillable = [
        'medicine_id', 'medicine_batch_id', 'date', 'type', 'quantity', 'reference', 'user_id', 'user_name', 'patient_id', 'supplier_id', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'integer',
    ];

    // Relationships
    public function medicine(): BelongsTo { return $this->belongsTo(Medicine::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('medicine_transactions');
    }
}
