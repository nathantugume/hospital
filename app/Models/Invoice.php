<?php

namespace App\Models;

use App\Models\Concerns\ScopesToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Invoice extends Model
{
    use HasFactory, LogsActivity, ScopesToCompany;

    protected $table = 'invoices';

    protected $fillable = [
        'code', 'company_id', 'patient_id', 'date', 'due_date', 'amount', 'paid_amount', 'balance', 'currency', 'status', 'insurance_status', 'insurance_provider', 'insurance_policy', 'insurance_group', 'payment_date', 'payment_method', 'payment_reference'
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function items(): HasMany { return $this->hasMany(InvoiceItem::class, 'invoice_id'); }
    public function services(): HasMany { return $this->hasMany(InvoiceService::class, 'invoice_id'); }
    public function insuranceClaims(): HasMany { return $this->hasMany(InsuranceClaim::class, 'invoice_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('invoices');
    }
}
