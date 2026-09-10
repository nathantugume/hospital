<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MedicineBatch extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'medicine_batches';

    protected $fillable = [
        'medicine_id', 'batch_number', 'mfg_date', 'expiry_date', 'quantity', 'status'
    ];

    protected $casts = [
        'mfg_date' => 'date',
        'expiry_date' => 'date',
        'quantity' => 'integer',
    ];

    // Relationships
    public function medicine(): BelongsTo { return $this->belongsTo(Medicine::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('medicine_batches');
    }
}
