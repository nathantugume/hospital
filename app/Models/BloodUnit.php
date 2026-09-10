<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BloodUnit extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'blood_units';

    protected $fillable = [
        'code', 'blood_type', 'units', 'collection_date', 'expiry_date', 'status', 'location', 'donor_id', 'donor_name'
    ];

    protected $casts = [
        'units' => 'integer',
        'collection_date' => 'date',
        'expiry_date' => 'date',
    ];

    // Relationships
    public function donor(): BelongsTo { return $this->belongsTo(BloodDonor::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('blood_units');
    }
}
