<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TestRequest extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'test_requests';

    protected $fillable = [
        'code', 'patient_id', 'doctor_id', 'priority', 'status', 'requested_date', 'notes'
    ];

    protected $casts = [
        'requested_date' => 'date',
    ];

    // Relationships
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function doctor(): BelongsTo { return $this->belongsTo(Staff::class, 'doctor_id'); }
    public function labTests(): BelongsToMany { return $this->belongsToMany(LabTest::class, 'testrequest_lab_test'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('test_requests');
    }
}
