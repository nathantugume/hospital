<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreStaffAvailabilityRequest;
use App\Http\Requests\Staff\StoreStaffLeaveRequest;
use App\Models\Staff;
use App\Models\StaffAvailability;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class DoctorAvailabilityController extends Controller
{
    public function index(Staff $doctor): View
    {
        $this->authorize('manageAvailability', $doctor);
        abort_unless($doctor->specialization !== null, 404);

        $availability = $doctor->availability()
            ->orderByRaw('date is null desc')
            ->orderBy('day_of_week')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
        $leaves = $doctor->leaves()->latest('start_date')->get();

        return view('doctors.availability', compact('doctor', 'availability', 'leaves'));
    }

    public function store(StoreStaffAvailabilityRequest $request, Staff $doctor): RedirectResponse
    {
        $this->authorize('manageAvailability', $doctor);
        abort_unless($doctor->specialization !== null, 404);

        $doctor->availability()->create([
            ...$request->validated(),
            'is_available' => $request->boolean('is_available', true),
        ]);

        return back()->with('status', 'Availability slot added.');
    }

    public function destroy(Staff $doctor, StaffAvailability $availability): RedirectResponse
    {
        $this->authorize('manageAvailability', $doctor);
        abort_unless($availability->staff_id === $doctor->id, 404);

        $availability->delete();

        return back()->with('status', 'Availability slot removed.');
    }

    public function storeLeave(StoreStaffLeaveRequest $request, Staff $doctor): RedirectResponse
    {
        $this->authorize('manageAvailability', $doctor);
        abort_unless($doctor->specialization !== null, 404);
        $data = $request->validated();
        $days = Carbon::parse($data['start_date'])->diffInDays(Carbon::parse($data['end_date'])) + 1;

        DB::transaction(function () use ($doctor, $data, $days, $request): void {
            Staff::query()->whereKey($doctor->id)->lockForUpdate()->firstOrFail();
            if ($request->user()->isAdmin()) {
                $this->assertNoAppointmentsDuringLeave($doctor, $data['start_date'], $data['end_date']);
            }
            $doctor->leaves()->create([
                ...$data,
                'duration' => $days.' '.($days === 1 ? 'day' : 'days'),
                'status' => $request->user()->isAdmin() ? 'Approved' : 'Pending',
                'approved_by' => $request->user()->isAdmin() ? $request->user()->staff_id : null,
            ]);
        });

        return back()->with('status', $request->user()->isAdmin() ? 'Time off approved.' : 'Time-off request submitted.');
    }

    public function updateLeave(Request $request, Staff $doctor, int $leave): RedirectResponse
    {
        $this->authorize('manageAvailability', $doctor);
        abort_unless($request->user()->isAdmin(), 403);
        $record = $doctor->leaves()->findOrFail($leave);
        $validated = $request->validate(['status' => ['required', 'in:Approved,Rejected']]);
        abort_unless($record->status === 'Pending', 409);
        if ($validated['status'] === 'Approved') {
            DB::transaction(function () use ($doctor, $record, $validated, $request): void {
                Staff::query()->whereKey($doctor->id)->lockForUpdate()->firstOrFail();
                $this->assertNoAppointmentsDuringLeave($doctor, $record->start_date, $record->end_date);
                $record->update([...$validated, 'approved_by' => $request->user()->staff_id]);
            });

            return back()->with('status', 'Time-off request updated.');
        }
        $record->update([...$validated, 'approved_by' => $request->user()->staff_id]);

        return back()->with('status', 'Time-off request updated.');
    }

    public function destroyLeave(Staff $doctor, int $leave): RedirectResponse
    {
        $this->authorize('manageAvailability', $doctor);
        $record = $doctor->leaves()->findOrFail($leave);
        abort_unless(request()->user()->isAdmin() || $record->status === 'Pending', 403);
        $record->delete();

        return back()->with('status', 'Time-off entry removed.');
    }

    private function assertNoAppointmentsDuringLeave(Staff $doctor, mixed $startDate, mixed $endDate): void
    {
        $hasAppointments = Appointment::query()
            ->where('company_id', $doctor->company_id)
            ->where('doctor_id', $doctor->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNotIn('status', ['Cancelled', 'No-Show'])
            ->exists();

        if ($hasAppointments) {
            throw ValidationException::withMessages([
                'start_date' => 'This doctor has active appointments during the selected leave period. Reschedule or cancel them first.',
            ]);
        }
    }
}
