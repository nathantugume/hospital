<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MobileMoneyTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'mobile_money_transactions';

    protected $fillable = [
        'code', 'provider', 'provider_reference', 'transaction_id', 'status', 'direction', 'amount', 'currency', 'payer_phone', 'payer_name', 'payee_note', 'payment_reason', 'invoice_id', 'patient_id', 'company_id', 'request_payload', 'response_payload', 'callback_payload', 'initiated_at', 'completed_at', 'error_message'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'initiated_at' => 'datetime',
        'completed_at' => 'datetime',
        'payer_phone' => 'encrypted',
    ];

    // Relationships
    public function invoice(): BelongsTo { return $this->belongsTo(Invoice::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('mobile_money_transactions');
    }
}
