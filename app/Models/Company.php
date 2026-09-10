<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Company extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'code', 'name', 'email', 'url', 'plan',
        'contact_person', 'phone', 'country', 'city', 'address',
        'beds_count', 'created_on', 'status', 'notes',
    ];

    protected $casts = [
        'created_on' => 'date',
        'beds_count' => 'integer',
        'phone' => 'encrypted',
    ];

    public function users(): HasMany { return $this->hasMany(User::class); }
    public function patients(): HasMany { return $this->hasMany(Patient::class); }
    public function staff(): HasMany { return $this->hasMany(Staff::class); }
    public function departments(): HasMany { return $this->hasMany(Department::class); }
    public function appointments(): HasMany { return $this->hasMany(Appointment::class); }
    public function invoices(): HasMany { return $this->hasMany(Invoice::class); }
    public function subscriptions(): HasMany { return $this->hasMany(Subscription::class); }
    public function purchaseTransactions(): HasMany { return $this->hasMany(PurchaseTransaction::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'plan', 'status'])->logOnlyDirty()->useLogName('company');
    }
}

class Subscription extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['code', 'company_id', 'plan', 'billing_cycle', 'payment_mode', 'amount', 'currency', 'created_on', 'expiring_on', 'status'];
    protected $casts = ['created_on' => 'date', 'expiring_on' => 'date', 'amount' => 'decimal:2'];
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function getActivitylogOptions(): LogOptions { return LogOptions::defaults()->logOnly(['plan', 'status', 'amount'])->logOnlyDirty()->useLogName('subscription'); }
}

class PurchaseTransaction extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['code', 'company_id', 'customer_name', 'email', 'created_on', 'amount', 'currency', 'payment_mode', 'status', 'plan'];
    protected $casts = ['created_on' => 'date', 'amount' => 'decimal:2'];
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function getActivitylogOptions(): LogOptions { return LogOptions::defaults()->logOnly(['status', 'amount', 'payment_mode'])->logOnlyDirty()->useLogName('purchase_transaction'); }
}
