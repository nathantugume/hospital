<?php

namespace App\Models;

use App\Models\Concerns\ScopesToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, ScopesToCompany;

    protected $fillable = [
        'company_id', 'name', 'code', 'head_staff_id',
        'staff_count', 'services_count', 'icon', 'description', 'status',
    ];

    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function head(): BelongsTo { return $this->belongsTo(Staff::class, 'head_staff_id'); }
    public function staff(): HasMany { return $this->hasMany(Staff::class); }
    public function wards(): HasMany { return $this->hasMany(Ward::class); }
    public function rooms(): HasMany { return $this->hasMany(Room::class); }
    public function services(): HasMany { return $this->hasMany(Service::class); }
    public function appointments(): HasMany { return $this->hasMany(Appointment::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'head_staff_id', 'status'])->logOnlyDirty()->useLogName('department');
    }
}

class Ward extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'name', 'code'];
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function rooms(): HasMany { return $this->hasMany(Room::class); }
    public function staff(): HasMany { return $this->hasMany(Staff::class); }
}
