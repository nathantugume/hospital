<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LabResultItem extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'lab_result_items';

    protected $fillable = [
        'lab_result_id', 'test', 'result', 'range', 'unit', 'flag'
    ];

    protected $casts = [
        // none
    ];

    // Relationships
    public function labResult(): BelongsTo { return $this->belongsTo(LabResult::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('lab_result_items');
    }
}
