<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Staff;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorController extends Controller
{
    /** Options mirrored from the add-doctor/edit-doctor templates' Position select. */
    public const POSITIONS = ['Consultant', 'Senior Resident', 'Junior Resident', 'Chief of Department', 'Attending Physician'];

    public const DEFAULT_SPECIALIZATIONS = ['Cardiology', 'Neurology', 'Pediatrics', 'Dermatology', 'Orthopedics', 'Radiology'];

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Staff::class);

        $doctors = Staff::query()
            ->forCompany($request->user())
            ->whereNotNull('specialization')
            ->with('department')
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('specialization', 'like', "%{$search}%");
                });
            })
            ->when($request->string('status')->trim()->value(), fn ($query, string $status) => $query->where('status', $status))
            ->when($request->string('specialty')->trim()->value(), fn ($query, string $specialty) => $query->where('specialization', $specialty))
            ->when($request->string('experience')->trim()->value(), function ($query, string $range): void {
                match ($range) {
                    '0-5' => $query->whereBetween('experience_years', [0, 5]),
                    '5-10' => $query->whereBetween('experience_years', [5, 10]),
                    '10-15' => $query->whereBetween('experience_years', [10, 15]),
                    '15+' => $query->where('experience_years', '>=', 15),
                    default => null,
                };
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(15)
            ->withQueryString();

        $doctors->getCollection()->transform(function (Staff $doctor) {
            $doctor->real_patients_count = $doctor->appointments()->distinct('patient_id')->count('patient_id');

            return $doctor;
        });

        $stats = [
            'total' => Staff::forCompany($request->user())->whereNotNull('specialization')->count(),
            'active' => Staff::forCompany($request->user())->whereNotNull('specialization')->where('status', 'Active')->count(),
            'on_leave' => Staff::forCompany($request->user())->whereNotNull('specialization')->where('status', 'On Leave')->count(),
            'departments' => Department::forCompany($request->user())->where('status', 'Active')->count(),
        ];

        $specialties = Staff::forCompany($request->user())->whereNotNull('specialization')->distinct()->orderBy('specialization')->pluck('specialization');

        return view('doctors.index', compact('doctors', 'stats', 'specialties'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Staff::class);
        $departments = Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get(['id', 'name']);

        return view('doctors.create', [
            'departments' => $departments,
            'positions' => self::POSITIONS,
            'specializations' => $this->specializationOptions($request),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Staff::class);
        $validated = $this->validated($request);
        Department::forCompany($request->user())->findOrFail($validated['department_id']);

        $doctor = Staff::create(array_merge(
            $this->staffAttributes($validated),
            ['company_id' => $request->user()->company_id, 'code' => $this->nextStaffCode(), 'status' => 'Active']
        ));

        $this->syncAccount($doctor, $request, $validated);

        return redirect()
            ->route('web.doctors.show', $doctor)
            ->with('status', "Dr. {$doctor->full_name} added successfully.");
    }

    public function show(Staff $doctor): View
    {
        $this->authorize('view', $doctor);
        abort_unless($doctor->specialization !== null, 404);

        $doctor->load('department');

        $appointments = $doctor->appointments()
            ->with('patient')
            ->latest('date')
            ->limit(10)
            ->get();

        $patientCount = $doctor->appointments()->distinct('patient_id')->count('patient_id');

        $performance = [
            'total_appointments' => $doctor->appointments()->count(),
            'completed' => $doctor->appointments()->where('status', 'Completed')->count(),
            'cancelled' => $doctor->appointments()->whereIn('status', ['Cancelled', 'No-Show'])->count(),
            'upcoming' => $doctor->appointments()->where('date', '>=', now()->toDateString())->count(),
        ];

        $todaysAppointments = $doctor->appointments()
            ->with('patient')
            ->whereDate('date', now()->toDateString())
            ->orderBy('start_time')
            ->get();

        return view('doctors.show', compact('doctor', 'appointments', 'patientCount', 'performance', 'todaysAppointments'));
    }

    public function edit(Request $request, Staff $doctor): View
    {
        $this->authorize('update', $doctor);
        abort_unless($doctor->specialization !== null, 404);

        $departments = Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get(['id', 'name']);

        return view('doctors.edit', [
            'doctor' => $doctor,
            'departments' => $departments,
            'positions' => self::POSITIONS,
            'specializations' => $this->specializationOptions($request),
            'account' => $doctor->user()->first(),
        ]);
    }

    public function update(Request $request, Staff $doctor): RedirectResponse
    {
        $this->authorize('update', $doctor);
        abort_unless($doctor->specialization !== null, 404);

        $validated = $this->validated($request, $doctor->id);
        Department::forCompany($request->user())->findOrFail($validated['department_id']);

        $doctor->update($this->staffAttributes($validated));

        $this->syncAccount($doctor, $request, $validated);

        return redirect()
            ->route('web.doctors.show', $doctor)
            ->with('status', "Dr. {$doctor->full_name} updated successfully.");
    }

    public function destroy(Staff $doctor): RedirectResponse
    {
        $this->authorize('delete', $doctor);
        abort_unless($doctor->specialization !== null, 404);

        $doctor->update(['status' => 'Inactive']);
        $doctor->user()->each(fn (User $user) => $user->delete());

        return redirect()
            ->route('web.doctors.index')
            ->with('status', "Dr. {$doctor->full_name} has been deactivated.");
    }

    private function validated(Request $request, ?int $ignoreStaffId = null): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('staff', 'email')->ignore($ignoreStaffId)],
            'phone' => ['required', 'string', 'max:30'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'primary_specialization' => ['required', Rule::in($this->specializationOptions($request)->all())],
            'secondary_specialization' => ['nullable', 'string', 'max:255'],
            'license' => ['nullable', 'string', 'max:100'],
            'license_expiry' => ['nullable', 'date'],
            'qualifications' => ['nullable', 'string'],
            'experience' => ['nullable', 'integer', 'min:0', 'max:70'],
            'education' => ['nullable', 'string'],
            'certifications' => ['nullable', 'string'],
            'department_id' => ['required', 'exists:departments,id'],
            'position' => ['required', Rule::in(self::POSITIONS)],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'account_email' => ['nullable', 'email', 'max:255'],
        ]);
    }

    private function specializationOptions(Request $request)
    {
        return Specialization::forCompany($request->user())->where('status', 'Active')->pluck('name')
            ->merge(Staff::forCompany($request->user())->whereNotNull('specialization')->distinct()->pluck('specialization'))
            ->merge(self::DEFAULT_SPECIALIZATIONS)
            ->filter()->unique()->sort()->values();
    }

    private function staffAttributes(array $validated): array
    {
        return [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'district' => $validated['state'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
            'role' => 'Doctor',
            'specialization' => $validated['primary_specialization'],
            'secondary_specialization' => ($validated['secondary_specialization'] ?? null) ?: null,
            'license_number' => $validated['license'] ?? null,
            'license_expiry' => $validated['license_expiry'] ?? null,
            'qualifications' => $validated['qualifications'] ?? null,
            'experience_years' => $validated['experience'] ?? 0,
            'education' => $this->combineEducation($validated),
            'department_id' => $validated['department_id'],
            'position' => $validated['position'],
        ];
    }

    private function nextStaffCode(): string
    {
        return 'ST-' . str_pad((string) (Staff::withTrashed()->max('id') + 1), 3, '0', STR_PAD_LEFT);
    }

    private function combineEducation(array $validated): ?string
    {
        $parts = array_filter([
            $validated['education'] ?? null,
            isset($validated['certifications']) && $validated['certifications'] !== ''
                ? "Certifications: {$validated['certifications']}"
                : null,
        ]);

        return $parts === [] ? null : implode("\n\n", $parts);
    }

    private function syncAccount(Staff $doctor, Request $request, array $validated): void
    {
        if (! $request->filled('account_email') && ! $request->filled('password')) {
            return;
        }

        $accountEmail = $validated['account_email'] ?: $validated['email'];

        $user = $doctor->user()->withTrashed()->first() ?? User::withTrashed()->where('email', $accountEmail)->first();

        $attributes = [
            'name' => $doctor->full_name,
            'email' => $accountEmail,
            'role' => 'doctor',
            'company_id' => $doctor->company_id,
            'staff_id' => $doctor->id,
        ];

        if ($request->filled('password')) {
            $attributes['password'] = Hash::make($validated['password']);
        }

        if ($user) {
            $user->update($attributes);
            if ($user->trashed()) {
                $user->restore();
            }

            return;
        }

        $attributes['password'] = Hash::make($validated['password'] ?? str()->random(16));
        $attributes['email_verified_at'] = now();
        User::create($attributes);
    }
}
