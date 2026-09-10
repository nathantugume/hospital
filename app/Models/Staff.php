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

class Staff extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, ScopesToCompany;

    protected $fillable = [
        'code', 'company_id', 'first_name', 'last_name', 'initials',
        'email', 'phone', 'alt_phone', 'date_of_birth', 'gender',
        'address', 'city', 'district', 'country',
        'role', 'position', 'department_id', 'ward_id',
        'specialization', 'secondary_specialization',
        'license_number', 'license_expiry',
        'qualifications', 'experience_years', 'education',
        'joined_date', 'patients_count', 'ward_patients_count',
        'avatar', 'avatar_initials', 'status',
        'emergency_contact_name', 'emergency_contact_phone',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'license_expiry' => 'date',
        'joined_date' => 'date',
        'experience_years' => 'integer',
        'patients_count' => 'integer',
        'ward_patients_count' => 'integer',
        'phone' => 'encrypted',
        'alt_phone' => 'encrypted',
        'address' => 'encrypted',
        'emergency_contact_phone' => 'encrypted',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    // Relationships
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function ward(): BelongsTo { return $this->belongsTo(Ward::class); }
    public function user(): HasMany { return $this->hasMany(User::class); }
    public function certifications(): HasMany { return $this->hasMany(StaffCertification::class); }
    public function education(): HasMany { return $this->hasMany(StaffEducation::class); }
    public function attendance(): HasMany { return $this->hasMany(StaffAttendance::class); }
    public function timesheets(): HasMany { return $this->hasMany(StaffTimesheet::class); }
    public function leaves(): HasMany { return $this->hasMany(StaffLeave::class); }
    public function availability(): HasMany { return $this->hasMany(StaffAvailability::class); }
    public function reviews(): HasMany { return $this->hasMany(StaffReview::class); }
    public function feedback(): HasMany { return $this->hasMany(PatientFeedback::class); }
    public function payrollEntries(): HasMany { return $this->hasMany(PayrollEntry::class); }
    public function ledDepartments(): HasMany { return $this->hasMany(Department::class, 'head_staff_id'); }

    // Clinical relationships (polymorphic — doctor in appointments, surgeon in surgeries, etc.)
    public function appointments(): HasMany { return $this->hasMany(Appointment::class, 'doctor_id'); }
    public function prescriptions(): HasMany { return $this->hasMany(Prescription::class, 'doctor_id'); }
    public function labResultsOrdered(): HasMany { return $this->hasMany(LabResult::class, 'ordered_by'); }
    public function labResultsVerified(): HasMany { return $this->hasMany(LabResult::class, 'verified_by'); }
    public function surgeriesAsSurgeon(): HasMany { return $this->hasMany(Surgery::class, 'surgeon_id'); }
    public function surgeriesAsAnesthesiologist(): HasMany { return $this->hasMany(Surgery::class, 'anesthesiologist_id'); }
    public function radiologyOrdersReferred(): HasMany { return $this->hasMany(RadiologyOrder::class, 'referring_doctor_id'); }
    public function radiologyOrdersAsRadiologist(): HasMany { return $this->hasMany(RadiologyOrder::class, 'radiologist_id'); }
    public function physiotherapySessions(): HasMany { return $this->hasMany(PhysiotherapySession::class, 'therapist_id'); }
    public function ambulancesDriven(): HasMany { return $this->hasMany(Ambulance::class, 'driver_id'); }
    public function ambulanceCallsDispatched(): HasMany { return $this->hasMany(AmbulanceCall::class, 'dispatcher_id'); }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['first_name', 'last_name', 'role', 'status'])->logOnlyDirty()->useLogName('staff');
    }
}

class StaffCertification extends Model
{
    use HasFactory;
    protected $table = 'staff_certifications';
    protected $fillable = ['staff_id', 'cert_name', 'issuing_body', 'issue_date', 'expiry_date', 'status'];
    protected $casts = ['issue_date' => 'date', 'expiry_date' => 'date'];
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
}

class StaffEducation extends Model
{
    use HasFactory;
    protected $table = 'staff_education';
    protected $fillable = ['staff_id', 'title', 'institution', 'year'];
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
}

class StaffAttendance extends Model
{
    use HasFactory;
    protected $table = 'staff_attendance';
    protected $fillable = ['staff_id', 'date', 'status', 'check_in', 'check_out', 'hours'];
    protected $casts = ['date' => 'date', 'check_in' => 'datetime:H:i', 'check_out' => 'datetime:H:i', 'hours' => 'decimal:2'];
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
}

class StaffTimesheet extends Model
{
    use HasFactory;
    protected $table = 'staff_timesheets';
    protected $fillable = ['staff_id', 'week_ending', 'hours', 'overtime_hours', 'status'];
    protected $casts = ['week_ending' => 'date', 'hours' => 'decimal:2', 'overtime_hours' => 'decimal:2'];
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
}

class StaffLeave extends Model
{
    use HasFactory;
    protected $table = 'staff_leaves';
    protected $fillable = ['staff_id', 'type', 'start_date', 'end_date', 'duration', 'status', 'reason', 'approved_by'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
    public function approver(): BelongsTo { return $this->belongsTo(Staff::class, 'approved_by'); }
}

class StaffReview extends Model
{
    use HasFactory;
    protected $table = 'staff_reviews';
    protected $fillable = ['staff_id', 'reviewer_id', 'period', 'review_date', 'rating', 'status', 'comments'];
    protected $casts = ['review_date' => 'date', 'rating' => 'decimal:1'];
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
    public function reviewer(): BelongsTo { return $this->belongsTo(Staff::class, 'reviewer_id'); }
}

class PatientFeedback extends Model
{
    use HasFactory;
    protected $fillable = ['staff_id', 'patient_id', 'date', 'rating', 'category', 'comment'];
    protected $casts = ['date' => 'date', 'rating' => 'integer'];
    public function staff(): BelongsTo { return $this->belongsTo(Staff::class); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
}
