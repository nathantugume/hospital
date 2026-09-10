<?php

namespace App\Models;

use App\Models\Concerns\ScopesThroughPatientCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LabResult extends Model
{
    use HasFactory, LogsActivity, ScopesThroughPatientCompany;

    protected $table = 'lab_results';

    protected $fillable = [
        'code', 'sample_id', 'patient_id', 'test_request_id', 'lab_test_id', 'test_name', 'result_value', 'normal_range', 'unit', 'result_date', 'collection_date', 'status', 'flag', 'ordered_by', 'verified_by', 'verified_date', 'notes', 'sample_type', 'department', 'attachment_url', 'share_token', 'share_expires_at'
    ];

    protected $casts = [
        'result_date' => 'date',
        'collection_date' => 'date',
        'verified_date' => 'datetime',
        'share_expires_at' => 'datetime',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function testRequest(): BelongsTo { return $this->belongsTo(TestRequest::class); }
    public function labTest(): BelongsTo { return $this->belongsTo(LabTest::class); }
    public function orderedBy(): BelongsTo { return $this->belongsTo(Staff::class, 'ordered_by'); }
    public function verifiedBy(): BelongsTo { return $this->belongsTo(Staff::class, 'verified_by'); }
    public function items(): HasMany { return $this->hasMany(LabResultItem::class, 'lab_result_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('lab_results');
    }
}
