<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffCertification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffCertificationController extends Controller
{
    public function store(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);
        $data = $request->validate([
            'cert_name' => ['required', 'string', 'max:255'],
            'issuing_body' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date', 'before_or_equal:today'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'status' => ['required', Rule::in(['valid', 'expired', 'revoked'])],
        ]);
        $staff->certifications()->create($data);

        return back()->with('status', 'Certification added successfully.');
    }

    public function update(Request $request, Staff $staff, StaffCertification $certification): RedirectResponse
    {
        $this->authorize('update', $staff);
        abort_unless($certification->staff_id === $staff->id, 404);
        $data = $request->validate([
            'cert_name' => ['required', 'string', 'max:255'],
            'issuing_body' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date', 'before_or_equal:today'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'status' => ['required', Rule::in(['valid', 'expired', 'revoked'])],
        ]);
        $certification->update($data);

        return back()->with('status', 'Certification updated successfully.');
    }

    public function destroy(Staff $staff, StaffCertification $certification): RedirectResponse
    {
        $this->authorize('update', $staff);
        abort_unless($certification->staff_id === $staff->id, 404);
        $certification->delete();

        return back()->with('status', 'Certification removed.');
    }
}
