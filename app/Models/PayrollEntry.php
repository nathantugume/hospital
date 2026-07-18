<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PayrollEntry extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'payroll_entries';

    protected $fillable = [
        'code', 'staff_id', 'employee_name', 'email', 'joining_date', 'role', 'salary', 'currency', 'status', 'payment_method', 'bank_name', 'bank_account', 'mobile_money_provider', 'mobile_money_number'
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
        'mobile_money_number' => 'encrypted',
    ];

    // Relationships
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
    public function payslips(): HasMany { return $this->hasMany(Payslip::class, 'payroll_entry_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('payroll_entries');
    }
}
