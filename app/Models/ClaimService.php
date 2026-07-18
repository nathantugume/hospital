<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ClaimService extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'claim_services';

    protected $fillable = [
        'claim_id', 'name', 'date', 'billed', 'allowed', 'patient_resp'
    ];

    protected $casts = [
        'date' => 'date',
        'billed' => 'decimal:2',
        'allowed' => 'decimal:2',
        'patient_resp' => 'decimal:2',
    ];

    // Relationships
    public function claim(): BelongsTo { return $this->belongsTo(InsuranceClaim::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('claim_services');
    }
}
