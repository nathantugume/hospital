@php
    $familyHistoryValue = old('family_history_notes');
    $checkedConditions = old('family_history_conditions', []);
    if ($patient->exists && empty($familyHistoryValue) && empty($checkedConditions) && $patient->family_history) {
        $parts = explode("\n", $patient->family_history, 2);
        $checkedConditions = array_intersect($familyHistoryConditions, array_map('trim', explode(',', $parts[0])));
        $familyHistoryValue = $parts[1] ?? (in_array($parts[0], $familyHistoryConditions, true) ? '' : $parts[0]);
    }
@endphp

<div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500 gap-1">
    <button type="button" data-tab="personal" class="patient-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Personal Information</button>
    <button type="button" data-tab="medical" class="patient-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Medical Information</button>
    <button type="button" data-tab="insurance" class="patient-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Insurance &amp; Billing</button>
    <button type="button" data-tab="consent" class="patient-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Consent &amp; Documents</button>
</div>

{{-- Personal Information --}}
<div data-tab-panel="personal" class="patient-tab-panel mt-4 space-y-4">
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b border-gray-100"><h2 class="text-xl font-semibold text-gray-900">Personal Information</h2><p class="text-gray-500">Enter the patient's personal details.</p></div>
        <div class="p-4 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-2"><label class="text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label><input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter first name"></div>
                <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Middle Name</label><input type="text" name="middle_name" value="{{ old('middle_name', $patient->middle_name) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter middle name"></div>
                <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label><input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter last name"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($patient->date_of_birth)->toDateString()) }}" required max="{{ now()->toDateString() }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select gender</option>
                        @foreach (['Male', 'Female', 'Other'] as $option)
                            <option value="{{ $option }}" @selected(old('gender', $patient->gender) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Marital Status</label>
                    <select name="marital_status" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select status</option>
                        @foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $option)
                            <option value="{{ $option }}" @selected(old('marital_status', $patient->marital_status) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Address</label><textarea name="address" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter address">{{ old('address', $patient->address) }}</textarea></div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><label class="text-sm font-medium text-gray-700">City</label><input type="text" name="city" value="{{ old('city', $patient->city) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="text-sm font-medium text-gray-700">District</label><input type="text" name="district" value="{{ old('district', $patient->district) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="text-sm font-medium text-gray-700">Postal Code</label><input type="text" name="postal_code" value="{{ old('postal_code', $patient->postal_code) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
            </div>
            <div class="shrink-0 bg-gray-200 h-px w-full my-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><label class="text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="{{ old('email', $patient->email) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label><input type="tel" name="phone" value="{{ old('phone', $patient->phone) }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="text-sm font-medium text-gray-700">Alternative Phone</label><input type="tel" name="alternate_phone" value="{{ old('alternate_phone', $patient->alternate_phone) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Preferred Contact Method</label>
                <div class="flex gap-4 text-gray-700">
                    @foreach (['phone' => 'Phone', 'email' => 'Email', 'sms' => 'SMS'] as $value => $label)
                        <label class="flex items-center gap-2"><input type="radio" name="preferred_contact" value="{{ $value }}" @checked(old('preferred_contact', $patient->preferred_contact ?: 'phone') === $value)> <span>{{ $label }}</span></label>
                    @endforeach
                </div>
            </div>
            <div class="shrink-0 bg-gray-200 h-px w-full my-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Emergency Contact</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><label class="text-sm font-medium text-gray-700">Contact Name</label><input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="text-sm font-medium text-gray-700">Relationship</label><input type="text" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="text-sm font-medium text-gray-700">Phone Number</label><input type="tel" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
            </div>
        </div>
    </div>
</div>

{{-- Medical Information --}}
<div data-tab-panel="medical" class="patient-tab-panel mt-4 space-y-4 hidden">
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b border-gray-100"><h2 class="text-xl font-semibold text-gray-900">Medical Information</h2><p class="text-gray-500">Enter the patient's medical history and details.</p></div>
        <div class="p-4 space-y-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 space-y-2">
                    <label class="text-sm font-medium text-gray-700">Blood Type</label>
                    <select name="blood_type" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select blood type</option>
                        @foreach (['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'] as $option)
                            <option value="{{ $option }}" @selected(old('blood_type', $patient->blood_type) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 space-y-2"><label class="text-sm font-medium text-gray-700">Height (cm)</label><input type="text" name="height" value="{{ old('height', $patient->height) }}" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter height"></div>
                <div class="flex-1 space-y-2"><label class="text-sm font-medium text-gray-700">Weight (kg)</label><input type="text" name="weight" value="{{ old('weight', $patient->weight) }}" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter weight"></div>
            </div>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Allergies</label><textarea name="allergies" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="List any allergies (medications, food, etc.)">{{ old('allergies', $patient->allergies) }}</textarea></div>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Current Medications</label><textarea name="current_medications" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="List any current medications">{{ old('current_medications', $patient->current_medications) }}</textarea></div>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Chronic Conditions</label><textarea name="chronic_conditions" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="List any chronic conditions">{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea></div>

            <div class="shrink-0 bg-gray-200 h-px w-full my-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Medical History</h3>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Past Surgeries</label><textarea name="past_surgeries" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="List any past surgeries with dates">{{ old('past_surgeries', $patient->past_surgeries) }}</textarea></div>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Previous Hospitalizations</label><textarea name="previous_hospitalizations" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="List any previous hospitalizations with dates">{{ old('previous_hospitalizations', $patient->medical_history) }}</textarea></div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 block mb-2">Family Medical History</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($familyHistoryConditions as $condition)
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer select-none">
                            <input type="checkbox" name="family_history_conditions[]" value="{{ $condition }}" @checked(in_array($condition, $checkedConditions, true)) class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            {{ $condition }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Additional Family History Notes</label><textarea name="family_history_notes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter any additional family medical history">{{ $familyHistoryValue }}</textarea></div>

            <div class="shrink-0 bg-gray-200 h-px w-full my-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Lifestyle Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Smoking Status</label>
                    <select name="smoking_status" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select status</option>
                        @foreach (['Never Smoked', 'Former Smoker', 'Current Smoker'] as $option)
                            <option value="{{ $option }}" @selected(old('smoking_status', $patient->smoking_status) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Alcohol Consumption</label>
                    <select name="alcohol_consumption" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select consumption</option>
                        @foreach (['None', 'Occasional', 'Moderate'] as $option)
                            <option value="{{ $option }}" @selected(old('alcohol_consumption', $patient->alcohol_consumption) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Insurance & Billing --}}
<div data-tab-panel="insurance" class="patient-tab-panel mt-4 space-y-4 hidden">
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b border-gray-100"><h2 class="text-xl font-semibold text-gray-900">Insurance &amp; Billing Information</h2><p class="text-gray-500">Enter the patient's primary insurance details.</p></div>
        <div class="p-4 space-y-6">
            <h3 class="text-lg font-medium text-gray-900">Primary Insurance</h3>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 space-y-2"><label class="text-sm font-medium text-gray-700">Insurance Provider</label><input type="text" name="insurance_provider" value="{{ old('insurance_provider', $insurance->provider) }}" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter insurance provider"></div>
                <div class="flex-1 space-y-2"><label class="text-sm font-medium text-gray-700">Policy Number</label><input type="text" name="insurance_policy_number" value="{{ old('insurance_policy_number', $insurance->policy_number) }}" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter policy number"></div>
            </div>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 space-y-2"><label class="text-sm font-medium text-gray-700">Group Number</label><input type="text" name="insurance_group_number" value="{{ old('insurance_group_number', $insurance->group_number) }}" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter group number"></div>
                <div class="flex-1 space-y-2"><label class="text-sm font-medium text-gray-700">Policy Holder Name</label><input type="text" name="insurance_policy_holder" value="{{ old('insurance_policy_holder', $insurance->policy_holder) }}" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter policy holder name"></div>
            </div>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 space-y-2">
                    <label class="text-sm font-medium text-gray-700">Relationship to Patient</label>
                    <select name="insurance_relationship" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select relationship</option>
                        @foreach (['Self', 'Spouse', 'Child', 'Parent'] as $option)
                            <option value="{{ $option }}" @selected(old('insurance_relationship', $insurance->relationship) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 space-y-2"><label class="text-sm font-medium text-gray-700">Insurance Phone Number</label><input type="tel" name="insurance_phone" value="{{ old('insurance_phone', $insurance->provider_phone) }}" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter insurance phone number"></div>
            </div>
            <p class="text-xs text-gray-500">Leave the provider blank if this patient is self-pay.</p>
        </div>
    </div>
</div>

{{-- Consent & Documents --}}
<div data-tab-panel="consent" class="patient-tab-panel mt-4 space-y-4 hidden">
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b border-gray-100"><h2 class="text-xl font-semibold text-gray-900">Consent &amp; Documents</h2><p class="text-gray-500">Record the patient's consent forms.</p></div>
        <div class="p-4 space-y-4">
            @php
                $consentLabels = [
                    'Data Protection Consent (DPPA Uganda 2019)' => "Patient consent for use and disclosure of health information",
                    'Treatment Consent' => 'Consent to receive medical treatment',
                    'Financial Agreement' => 'Agreement to pay for services',
                ];
                $givenConsents = old('consents', $patient->exists ? $patient->consents->where('consent_status', 'Given')->pluck('consent_type')->all() : []);
            @endphp
            @foreach ($consentTypes as $type)
                <label class="flex items-center justify-between p-4 border border-gray-200 rounded-md flex-wrap gap-3 cursor-pointer">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $type }}</h4>
                        <p class="text-sm text-gray-500">{{ $consentLabels[$type] }}</p>
                    </div>
                    <input type="checkbox" name="consents[]" value="{{ $type }}" @checked(in_array($type, $givenConsents, true)) class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                </label>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const tabs = document.querySelectorAll('.patient-tab');
    const panels = document.querySelectorAll('.patient-tab-panel');

    function activate(name) {
        tabs.forEach((tab) => {
            const isActive = tab.dataset.tab === name;
            tab.classList.toggle('bg-background', isActive);
            tab.classList.toggle('shadow-sm', isActive);
            tab.classList.toggle('text-gray-900', isActive);
            tab.classList.toggle('text-gray-500', !isActive);
        });
        panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.tabPanel !== name));
    }

    tabs.forEach((tab) => tab.addEventListener('click', () => activate(tab.dataset.tab)));
    activate('personal');
})();
</script>
@endpush
