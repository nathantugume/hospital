<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class NationalIdVerification extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'national_id_verifications';

    protected $fillable = [
        'verification_id', 'national_id', 'country', 'provider', 'full_name', 'date_of_birth', 'gender', 'photo_url', 'status', 'request_payload', 'response_payload', 'error_message', 'patient_id', 'user_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'national_id' => 'encrypted',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('national_id_verifications');
    }
}
