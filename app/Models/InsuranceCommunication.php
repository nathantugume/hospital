<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InsuranceCommunication extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'insurance_communications';

    protected $fillable = [
        'claim_id', 'direction', 'message_type', 'request_body', 'response_body', 'status_code'
    ];

    protected $casts = [
        // none
    ];

    // Relationships
    public function claim(): BelongsTo { return $this->belongsTo(InsuranceClaim::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('insurance_communications');
    }
}
