<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BloodDonor extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'blood_donors';

    protected $fillable = [
        'code', 'name', 'blood_type', 'phone', 'email', 'address', 'last_donation', 'status', 'total_donations', 'next_eligible', 'donor_tier'
    ];

    protected $casts = [
        'last_donation' => 'date',
        'next_eligible' => 'date',
        'total_donations' => 'integer',
        'phone' => 'encrypted',
        'address' => 'encrypted',
    ];

    // Relationships
    public function donations(): HasMany { return $this->hasMany(BloodDonation::class, 'donor_id'); }
    public function bloodUnits(): HasMany { return $this->hasMany(BloodUnit::class, 'donor_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('blood_donors');
    }
}
