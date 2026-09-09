<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientConsent;
use App\Models\PatientInsurance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    private const CONSENT_TYPES = [
        'Data Protection Consent (DPPA Uganda 2019)',
        'Treatment Consent',
        'Financial Agreement',
    ];

    private const FAMILY_HISTORY_CONDITIONS = [
        'Diabetes', 'Heart Disease', 'Hypertension', 'Cancer', 'Asthma', 'Mental Health Conditions',
    ];

    public function index(Request $request): View
    {
        $patients = Patient::query()
            ->with('latestAppointment.doctor')
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($request->string('status')->trim()->value(), fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create(): View
    {
        return view('patients.create', [
            'patient' => new Patient(),
            'insurance' => new PatientInsurance(),
            'consentTypes' => self::CONSENT_TYPES,
            'familyHistoryConditions' => self::FAMILY_HISTORY_CONDITIONS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        $patient = Patient::create($this->patientAttributes($validated, $request));

        $this->syncInsurance($patient, $request);
        $this->syncConsents($patient, $request);

        return redirect()
            ->route('web.patients.show', $patient)
            ->with('status', "Patient {$patient->code} registered successfully.");
    }

    public function show(Patient $patient): View
    {
        $patient->load([
            'primaryInsurance',
            'consents',
            'appointments' => fn ($query) => $query->latest('date')->limit(8),
            'appointments.doctor',
            'appointments.department',
            'invoices' => fn ($query) => $query->latest()->limit(8),
            'prescriptions' => fn ($query) => $query->latest('date')->limit(8),
            'prescriptions.doctor',
            'labResults' => fn ($query) => $query->latest('result_date')->limit(8),
        ]);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient): View
    {
        $patient->load('primaryInsurance', 'consents');

        return view('patients.edit', [
            'patient' => $patient,
            'insurance' => $patient->primaryInsurance ?? new PatientInsurance(),
            'consentTypes' => self::CONSENT_TYPES,
            'familyHistoryConditions' => self::FAMILY_HISTORY_CONDITIONS,
        ]);
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $validated = $this->validated($request);

        $patient->update($this->patientAttributes($validated, $request));

        $this->syncInsurance($patient, $request);
        $this->syncConsents($patient, $request);

        return redirect()
            ->route('web.patients.show', $patient)
            ->with('status', "Patient {$patient->code} updated successfully.");
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        $patient->delete();

        return redirect()
            ->route('web.patients.index')
            ->with('status', "Patient {$patient->code} has been removed.");
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'marital_status' => ['nullable', 'in:Single,Married,Divorced,Widowed'],
            'address' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'alternate_phone' => ['nullable', 'string', 'max:30'],
            'preferred_contact' => ['nullable', 'in:phone,email,sms'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:50'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'blood_type' => ['nullable', 'string', 'max:5'],
            'height' => ['nullable', 'string', 'max:20'],
            'weight' => ['nullable', 'string', 'max:20'],
            'allergies' => ['nullable', 'string', 'max:2000'],
            'current_medications' => ['nullable', 'string', 'max:2000'],
            'chronic_conditions' => ['nullable', 'string', 'max:2000'],
            'past_surgeries' => ['nullable', 'string', 'max:2000'],
            'previous_hospitalizations' => ['nullable', 'string', 'max:2000'],
            'family_history_conditions' => ['nullable', 'array'],
            'family_history_conditions.*' => ['string'],
            'family_history_notes' => ['nullable', 'string', 'max:2000'],
            'smoking_status' => ['nullable', 'in:Never Smoked,Former Smoker,Current Smoker'],
            'alcohol_consumption' => ['nullable', 'in:None,Occasional,Moderate'],
            'insurance_provider' => ['nullable', 'string', 'max:255'],
            'insurance_policy_number' => ['nullable', 'string', 'max:100'],
            'insurance_group_number' => ['nullable', 'string', 'max:100'],
            'insurance_policy_holder' => ['nullable', 'string', 'max:255'],
            'insurance_relationship' => ['nullable', 'in:Self,Spouse,Child,Parent'],
            'insurance_phone' => ['nullable', 'string', 'max:30'],
            'consents' => ['nullable', 'array'],
            'consents.*' => ['string'],
        ]);
    }

    private function patientAttributes(array $validated, Request $request): array
    {
        $familyHistory = trim(
            implode(', ', $validated['family_history_conditions'] ?? [])
            . (! empty($validated['family_history_notes']) ? "\n" . $validated['family_history_notes'] : '')
        );

        return [
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'marital_status' => $validated['marital_status'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'district' => $validated['district'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'],
            'alternate_phone' => $validated['alternate_phone'] ?? null,
            'preferred_contact' => $validated['preferred_contact'] ?? 'phone',
            'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
            'emergency_contact_relationship' => $validated['emergency_contact_relationship'] ?? null,
            'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
            'blood_type' => $validated['blood_type'] ?? null,
            'height' => $validated['height'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'allergies' => $validated['allergies'] ?? null,
            'current_medications' => $validated['current_medications'] ?? null,
            'chronic_conditions' => $validated['chronic_conditions'] ?? null,
            'past_surgeries' => $validated['past_surgeries'] ?? null,
            'medical_history' => $validated['previous_hospitalizations'] ?? null,
            'family_history' => $familyHistory !== '' ? $familyHistory : null,
            'smoking_status' => $validated['smoking_status'] ?? null,
            'alcohol_consumption' => $validated['alcohol_consumption'] ?? null,
        ] + (
            $request->route('patient') ? [] : ['code' => $this->nextPatientCode(), 'status' => 'Active']
        );
    }

    private function nextPatientCode(): string
    {
        return 'P-' . str_pad((string) (Patient::withTrashed()->max('id') + 1), 5, '0', STR_PAD_LEFT);
    }

    private function syncInsurance(Patient $patient, Request $request): void
    {
        if (! $request->filled('insurance_provider')) {
            return;
        }

        $patient->insurances()->updateOrCreate(
            ['is_primary' => true],
            [
                'provider' => $request->string('insurance_provider')->value(),
                'policy_number' => $request->string('insurance_policy_number')->value() ?: null,
                'group_number' => $request->string('insurance_group_number')->value() ?: null,
                'policy_holder' => $request->string('insurance_policy_holder')->value() ?: null,
                'relationship' => $request->string('insurance_relationship')->value() ?: 'Self',
                'provider_phone' => $request->string('insurance_phone')->value() ?: null,
                'verification_status' => 'Pending',
            ]
        );
    }

    private function syncConsents(Patient $patient, Request $request): void
    {
        $given = $request->input('consents', []);

        foreach (self::CONSENT_TYPES as $type) {
            if (in_array($type, $given, true)) {
                $patient->consents()->updateOrCreate(
                    ['consent_type' => $type],
                    ['consent_status' => 'Given', 'signed_at' => now()]
                );
            }
        }
    }
}
