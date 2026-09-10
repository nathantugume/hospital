<?php

namespace App\Models;

use App\Models\Concerns\ScopesThroughDepartmentCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Service extends Model
{
    use HasFactory, LogsActivity, ScopesThroughDepartmentCompany;

    protected $table = 'services';

    protected $fillable = [
        'name', 'department_id', 'department_name', 'type', 'duration', 'price', 'currency', 'popularity', 'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'popularity' => 'integer',
    ];

    // Relationships
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function availability(): HasMany { return $this->hasMany(ServiceAvailability::class, 'service_id'); }
    public function providers(): HasMany { return $this->hasMany(ServiceProvider::class, 'service_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('services');
    }
}
