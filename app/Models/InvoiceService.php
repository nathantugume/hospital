<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InvoiceService extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'invoice_services';

    protected $fillable = [
        'invoice_id', 'service_id', 'billed', 'allowed', 'patient_resp'
    ];

    protected $casts = [
        'billed' => 'decimal:2',
        'allowed' => 'decimal:2',
        'patient_resp' => 'decimal:2',
    ];

    // Relationships
    public function invoice(): BelongsTo { return $this->belongsTo(Invoice::class); }
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('invoice_services');
    }
}
