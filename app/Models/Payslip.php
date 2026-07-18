<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payslip extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'payslips';

    protected $fillable = [
        'code', 'payroll_entry_id', 'period', 'gross_salary', 'deductions', 'net_salary', 'currency', 'status', 'generated_at', 'paid_at'
    ];

    protected $casts = [
        'gross_salary' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'generated_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    // Relationships
    public function payrollEntry(): BelongsTo { return $this->belongsTo(PayrollEntry::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('payslips');
    }
}
