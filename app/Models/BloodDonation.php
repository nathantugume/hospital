<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BloodDonation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'blood_donations';

    protected $fillable = [
        'donor_id', 'blood_unit_id', 'date', 'type', 'volume', 'location', 'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function donor(): BelongsTo { return $this->belongsTo(BloodDonor::class); }
    public function bloodUnit(): BelongsTo { return $this->belongsTo(BloodUnit::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('blood_donations');
    }
}
