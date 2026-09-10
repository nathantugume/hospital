<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role',
        'company_id', 'staff_id', 'patient_id',
        'avatar', 'preferred_language', 'preferred_currency', 'timezone',
        'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
        'two_factor_secret', 'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_confirmed_at' => 'datetime',
        'phone' => 'encrypted',
    ];

    protected $appends = ['role_label'];

    // ============================================================
    // RBAC helpers
    // ============================================================
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }
        return $this->role === $roles;
    }

    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function isAdmin(): bool { return in_array($this->role, ['super_admin', 'admin'], true); }
    public function isDoctor(): bool { return $this->role === 'doctor'; }
    public function isNurse(): bool { return $this->role === 'nurse'; }
    public function isReceptionist(): bool { return $this->role === 'receptionist'; }
    public function isLabTech(): bool { return $this->role === 'lab_technician'; }
    public function isPharmacist(): bool { return $this->role === 'pharmacist'; }
    public function isPatient(): bool { return $this->role === 'patient'; }
    public function isAccountant(): bool { return $this->role === 'accountant'; }
    public function isInsuranceOfficer(): bool { return $this->role === 'insurance_officer'; }
    public function isHrManager(): bool { return $this->role === 'hr_manager'; }
    public function isInventoryManager(): bool { return $this->role === 'inventory_manager'; }
    public function isAmbulanceDispatcher(): bool { return $this->role === 'ambulance_dispatcher'; }
    public function isAmbulanceDriver(): bool { return $this->role === 'ambulance_driver'; }
    public function isSurgeon(): bool { return $this->role === 'surgeon'; }
    public function isBloodBankStaff(): bool { return $this->role === 'blood_bank_staff'; }
    public function isPhysiotherapist(): bool { return $this->role === 'physiotherapist'; }
    public function isRadiologyTech(): bool { return $this->role === 'radiology_technician'; }

    public function getRoleLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->role));
    }

    // ============================================================
    // Relationships
    // ============================================================
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function notifications(): HasMany { return $this->hasMany(Notification::class); }
    public function calendarEvents(): HasMany { return $this->hasMany(CalendarEvent::class); }
    public function chatThreads(): HasMany { return $this->hasMany(ChatThread::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role', 'status'])
            ->logOnlyDirty()
            ->useLogName('user');
    }
}
