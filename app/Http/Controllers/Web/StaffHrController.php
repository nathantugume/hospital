<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffAttendance;
use App\Models\StaffLeave;
use App\Models\StaffReview;
use App\Models\StaffTimesheet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class StaffHrController extends Controller
{
    public function show(Staff $staff): View
    {
        $this->authorize('update', $staff);
        $staff->load(['attendance' => fn ($q) => $q->latest('date'), 'timesheets' => fn ($q) => $q->latest('week_ending'), 'leaves' => fn ($q) => $q->latest('start_date'), 'reviews' => fn ($q) => $q->latest('review_date')]);
        return view('staff.hr', compact('staff'));
    }

    public function storeAttendance(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);
        $data = $request->validate(['date' => ['required', 'date'], 'status' => ['required', Rule::in(['Present', 'Absent', 'Late', 'On Leave'])], 'check_in' => ['nullable', 'date_format:H:i'], 'check_out' => ['nullable', 'date_format:H:i', 'after:check_in'], 'hours' => ['nullable', 'numeric', 'min:0', 'max:24']]);
        $staff->attendance()->updateOrCreate(['date' => $data['date']], $data);
        return back()->with('status', 'Attendance saved.');
    }

    public function storeTimesheet(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);
        $data = $request->validate(['week_ending' => ['required', 'date'], 'hours' => ['required', 'numeric', 'min:0', 'max:168'], 'overtime_hours' => ['required', 'numeric', 'min:0', 'max:168'], 'status' => ['required', Rule::in(['Pending', 'Approved', 'Rejected'])]]);
        $staff->timesheets()->updateOrCreate(['week_ending' => $data['week_ending']], $data);
        return back()->with('status', 'Timesheet saved.');
    }

    public function storeLeave(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);
        $data = $request->validate(['type' => ['required', Rule::in(['Annual', 'Sick', 'Maternity', 'Paternity', 'Study', 'Unpaid'])], 'start_date' => ['required', 'date'], 'end_date' => ['required', 'date', 'after_or_equal:start_date'], 'status' => ['required', Rule::in(['Pending', 'Approved', 'Rejected'])], 'reason' => ['nullable', 'string', 'max:2000']]);
        $data['duration'] = Carbon::parse($data['start_date'])->diffInDays(Carbon::parse($data['end_date'])) + 1 . ' day(s)';
        if ($data['status'] === 'Approved') { $data['approved_by'] = $request->user()->staff_id; }
        $staff->leaves()->create($data);
        return back()->with('status', 'Leave record added.');
    }

    public function updateLeave(Request $request, Staff $staff, StaffLeave $leave): RedirectResponse
    {
        $this->authorize('update', $staff); $this->assertOwned($staff, $leave);
        $data = $request->validate(['status' => ['required', Rule::in(['Pending', 'Approved', 'Rejected'])]]);
        $leave->update($data + ['approved_by' => $data['status'] === 'Approved' ? $request->user()->staff_id : null]);
        return back()->with('status', 'Leave status updated.');
    }

    public function storeReview(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);
        $data = $request->validate(['period' => ['required', 'string', 'max:50'], 'review_date' => ['required', 'date'], 'rating' => ['required', 'numeric', 'between:1,5'], 'status' => ['required', Rule::in(['Pending', 'Completed', 'Acknowledged'])], 'comments' => ['nullable', 'string', 'max:4000']]);
        $staff->reviews()->create($data + ['reviewer_id' => $request->user()->staff_id]);
        return back()->with('status', 'Performance review added.');
    }

    private function assertOwned(Staff $staff, StaffLeave|StaffAttendance|StaffTimesheet|StaffReview $record): void
    {
        abort_unless($record->staff_id === $staff->id, 404);
    }
}
