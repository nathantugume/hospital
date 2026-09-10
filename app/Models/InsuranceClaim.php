<?php

namespace App\Models;

use App\Models\Concerns\ScopesToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InsuranceClaim extends Model
{
    use HasFactory, LogsActivity, ScopesToCompany;

    protected $table = 'insurance_claims';

    protected $fillable = [
        'code', 'company_id', 'patient_id', 'invoice_id', 'insurance_provider_id', 'provider', 'policy_number', 'group_number', 'relationship', 'submitted_date', 'amount', 'approved_amount', 'currency', 'status', 'type', 'payment_date', 'patient_responsibility', 'rejection_reason', 'notes'
    ];

    protected $casts = [
        'submitted_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'patient_responsibility' => 'decimal:2',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function invoice(): BelongsTo { return $this->belongsTo(Invoice::class); }
    public function provider(): BelongsTo { return $this->belongsTo(InsuranceProvider::class, 'insurance_provider_id'); }
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function services(): HasMany { return $this->hasMany(ClaimService::class, 'claim_id'); }
    public function communications(): HasMany { return $this->hasMany(InsuranceCommunication::class, 'claim_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('insurance_claims');
    }
}
