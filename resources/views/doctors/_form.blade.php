@php
    $doctor = $doctor ?? new \App\Models\Staff();
    $account = $account ?? null;

    $educationValue = old('education');
    $certificationsValue = old('certifications');
    if ($doctor->exists && $educationValue === null && $certificationsValue === null && $doctor->education) {
        $parts = explode("\n\nCertifications: ", $doctor->education, 2);
        $educationValue = $parts[0];
        $certificationsValue = $parts[1] ?? '';
    }
@endphp

<div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500 gap-1">
    <button type="button" data-tab="personal" class="doctor-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Personal Information</button>
    <button type="button" data-tab="professional" class="doctor-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Professional Details</button>
    <button type="button" data-tab="account" class="doctor-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Account Settings</button>
</div>

{{-- Personal Information --}}
<div data-tab-panel="personal" class="doctor-tab-panel mt-4 space-y-4">
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b border-gray-100"><h2 class="text-xl font-semibold text-gray-900">Personal Information</h2><p class="text-gray-500">Enter the doctor's personal details.</p></div>
        <div class="p-4 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2"><label class="text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label><input type="text" name="first_name" value="{{ old('first_name', $doctor->first_name) }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter first name"></div>
                <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label><input type="text" name="last_name" value="{{ old('last_name', $doctor->last_name) }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter last name"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($doctor->date_of_birth)->toDateString()) }}" max="{{ now()->toDateString() }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select gender</option>
                        @foreach (['Male', 'Female', 'Other'] as $option)
                            <option value="{{ $option }}" @selected(old('gender', $doctor->gender) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="space-y-2"><label class="text-sm font-medium text-gray-700">Address</label><textarea name="address" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter address">{{ old('address', $doctor->address) }}</textarea></div>
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="text-sm font-medium text-gray-700">City</label><input type="text" name="city" value="{{ old('city', $doctor->city) }}" class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                <div><label class="text-sm font-medium text-gray-700">State</label><input type="text" name="state" value="{{ old('state', $doctor->district) }}" class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
            </div>
            <div class="shrink-0 bg-gray-200 h-px w-full my-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label><input type="email" name="email" value="{{ old('email', $doctor->email) }}" required class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter email"></div>
                <div><label class="text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label><input type="tel" name="phone" value="{{ old('phone', $doctor->phone) }}" required class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter phone number"></div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="text-sm font-medium text-gray-700">Emergency Contact Name</label><input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $doctor->emergency_contact_name) }}" class="w-full border rounded-md px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium text-gray-700">Emergency Contact Phone</label><input type="tel" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $doctor->emergency_contact_phone) }}" class="w-full border rounded-md px-3 py-2 text-sm"></div>
            </div>
        </div>
    </div>
</div>

{{-- Professional Details --}}
<div data-tab-panel="professional" class="doctor-tab-panel mt-4 space-y-4 hidden">
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b border-gray-100"><h2 class="text-xl font-semibold text-gray-900">Professional Details</h2><p class="text-gray-500">Enter the doctor's professional information.</p></div>
        <div class="p-4 space-y-5">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Primary Specialization <span class="text-red-500">*</span></label>
                    <select name="primary_specialization" required class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select specialization</option>
                        @foreach ($specializations as $option)
                            <option value="{{ $option }}" @selected(old('primary_specialization', $doctor->specialization) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Secondary Specialization (Optional)</label>
                    <select name="secondary_specialization" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">None</option>
                        @foreach ($specializations as $option)
                            <option value="{{ $option }}" @selected(old('secondary_specialization', $doctor->secondary_specialization) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div><label class="text-sm font-medium text-gray-700">Medical License Number</label><input type="text" name="license" value="{{ old('license', $doctor->license_number) }}" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="Enter license number"></div>
                <div><label class="text-sm font-medium text-gray-700">License Expiry Date</label><input type="date" name="license_expiry" value="{{ old('license_expiry', optional($doctor->license_expiry)->toDateString()) }}" class="w-full border rounded-md px-3 py-2 text-sm"></div>
            </div>
            <div><label class="text-sm font-medium text-gray-700">Qualifications</label><textarea name="qualifications" rows="2" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="MD, PhD, etc.">{{ old('qualifications', $doctor->qualifications) }}</textarea></div>
            <div><label class="text-sm font-medium text-gray-700">Years of Experience</label><input type="number" name="experience" min="0" max="70" value="{{ old('experience', $doctor->experience_years) }}" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="Enter years"></div>
            <div class="shrink-0 bg-gray-200 h-px w-full my-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Education &amp; Training</h3>
            <div><label class="text-sm font-medium text-gray-700">Education</label><textarea name="education" rows="2" class="w-full border rounded-md px-3 py-2 mt-1 text-sm" placeholder="Medical school, residency">{{ $educationValue }}</textarea></div>
            <div><label class="text-sm font-medium text-gray-700">Certifications</label><textarea name="certifications" rows="2" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="Board certifications">{{ $certificationsValue }}</textarea></div>
            <div class="shrink-0 bg-gray-200 h-px w-full my-4"></div>
            <h3 class="text-lg font-medium text-gray-900">Department &amp; Position</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" required class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected((int) old('department_id', $doctor->department_id) === $department->id)>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Position <span class="text-red-500">*</span></label>
                    <select name="position" required class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select position</option>
                        @foreach ($positions as $option)
                            <option value="{{ $option }}" @selected(old('position', $doctor->position) === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Account Settings --}}
<div data-tab-panel="account" class="doctor-tab-panel mt-4 space-y-4 hidden">
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b border-gray-100"><h2 class="text-xl font-semibold text-gray-900">Account Settings</h2><p class="text-gray-500">Configure the doctor's account and system access.</p></div>
        <div class="p-4 space-y-5">
            <div>
                <label class="text-sm font-medium text-gray-700">Login Email</label>
                <input type="email" name="account_email" value="{{ old('account_email', $account->email ?? '') }}" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="doctor@hospital.ug">
                <p class="text-xs text-gray-500 mt-1">Used for login and notifications. Leave blank to reuse the personal email above.</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">{{ $account ?? null ? 'Reset Password' : 'Temporary Password' }}</label>
                <input type="password" name="password" class="w-full border rounded-md px-3 py-2 text-sm" placeholder="{{ $account ?? null ? 'Leave blank to keep current password' : 'Enter password (min. 8 characters)' }}">
                <p class="text-xs text-gray-500 mt-1">{{ $account ?? null ? 'Only fill this in to change the doctor\'s login password.' : 'Leave blank to auto-generate a login account without a chosen password.' }}</p>
            </div>
            @if ($account ?? null)
                <p class="text-xs text-gray-500">This doctor already has a login account ({{ $account->email }}).</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const tabs = document.querySelectorAll('.doctor-tab');
    const panels = document.querySelectorAll('.doctor-tab-panel');

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
