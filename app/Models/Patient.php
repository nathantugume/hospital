<?php

namespace App\Models;

use App\Models\Concerns\ScopesToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, ScopesToCompany;

    protected $table = 'patients';

    protected $fillable = [
        'code', 'company_id',
        'first_name', 'middle_name', 'last_name',
        'date_of_birth', 'age', 'gender', 'marital_status',
        'blood_type', 'height', 'weight',
        'phone', 'alternate_phone', 'email', 'address',
        'city', 'district', 'country', 'postal_code', 'preferred_contact',
        'national_id', 'national_id_type', 'nationality',
        'condition', 'allergies', 'current_medications',
        'chronic_conditions', 'past_surgeries', 'family_history', 'medical_history',
        'hiv_status', 'smoking_status', 'alcohol_consumption',
        'emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_phone',
        'avatar', 'avatar_initials', 'last_visit', 'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_visit' => 'date',
        // PII columns encrypted at application layer
        'phone' => 'encrypted',
        'alternate_phone' => 'encrypted',
        'email' => 'encrypted',
        'address' => 'encrypted',
        'national_id' => 'encrypted',
        'medical_history' => 'encrypted',
        'emergency_contact_phone' => 'encrypted',
    ];

    protected $appends = ['full_name', 'initials'];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getInitialsAttribute(): string
    {
        $f = strtoupper(substr($this->first_name ?? '', 0, 1));
        $l = strtoupper(substr($this->last_name ?? '', 0, 1));
        return $f . $l;
    }

    // ============================================================
    // Relationships
    // ============================================================
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function emergencyContacts(): HasMany { return $this->hasMany(PatientEmergencyContact::class); }
    public function insurances(): HasMany { return $this->hasMany(PatientInsurance::class); }
    public function primaryInsurance(): HasOne { return $this->hasOne(PatientInsurance::class)->where('is_primary', true); }
    public function consents(): HasMany { return $this->hasMany(PatientConsent::class); }
    public function appointments(): HasMany { return $this->hasMany(Appointment::class); }
    public function latestAppointment(): HasOne { return $this->hasOne(Appointment::class)->ofMany(['date' => 'max', 'id' => 'max']); }
    public function appointmentRequests(): HasMany { return $this->hasMany(AppointmentRequest::class); }
    public function invoices(): HasMany { return $this->hasMany(Invoice::class); }
    public function insuranceClaims(): HasMany { return $this->hasMany(InsuranceClaim::class); }
    public function prescriptions(): HasMany { return $this->hasMany(Prescription::class); }
    public function labResults(): HasMany { return $this->hasMany(LabResult::class); }
    public function testRequests(): HasMany { return $this->hasMany(TestRequest::class); }
    public function radiologyOrders(): HasMany { return $this->hasMany(RadiologyOrder::class); }
    public function surgeries(): HasMany { return $this->hasMany(Surgery::class); }
    public function physiotherapySessions(): HasMany { return $this->hasMany(PhysiotherapySession::class); }
    public function roomAllotments(): HasMany { return $this->hasMany(RoomAllotment::class); }
    public function bloodIssues(): HasMany { return $this->hasMany(BloodIssue::class); }
    public function vaccinations(): HasMany { return $this->hasMany(Vaccination::class); }
    public function birthRecord(): HasOne { return $this->hasOne(BirthRecord::class); }
    public function deathRecord(): HasOne { return $this->hasOne(DeathRecord::class); }
    public function feedback(): HasMany { return $this->hasMany(PatientFeedback::class); }
    public function medicationAdministrations(): HasMany { return $this->hasMany(MedicationAdministration::class); }
    public function user(): HasOne { return $this->hasOne(User::class); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['first_name', 'last_name', 'status', 'phone'])
            ->logOnlyDirty()
            ->useLogName('patient');
    }
}
