<?php

namespace App\Models;

use App\Models\Concerns\ScopesToCompanyOrShared;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LabTest extends Model
{
    use HasFactory, LogsActivity, ScopesToCompanyOrShared;

    protected $table = 'lab_tests';

    protected $fillable = [
        'company_id', 'code', 'name', 'department', 'sample_type', 'price', 'currency', 'target_turnaround_hours', 'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'target_turnaround_hours' => 'decimal:1',
    ];

    // Relationships
        // none

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('lab_tests');
    }
}
