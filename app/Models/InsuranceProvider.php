<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InsuranceProvider extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'insurance_providers';

    protected $fillable = [
        'name', 'code', 'country', 'api_url', 'api_key', 'api_provider_key', 'phone', 'email', 'status'
    ];

    protected $casts = [
        'api_key' => 'encrypted',
    ];

    // Relationships
    public function claims(): HasMany { return $this->hasMany(InsuranceClaim::class, 'insurance_provider_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->logOnlyDirty()
            ->useLogName('insurance_providers');
    }
}
