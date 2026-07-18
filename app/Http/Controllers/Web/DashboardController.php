<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $patient = $user->patient;

        if ($user->isPatient() && $patient) {
            $stats = [
                'patients' => 1,
                'staff' => 0,
                'appointments' => $patient->appointments()->whereDate('date', today())->count(),
                'outstanding' => $patient->invoices()->sum('balance'),
                'medicines' => 0,
            ];
            $upcomingAppointments = $patient->appointments()
                ->with(['doctor', 'department'])
                ->whereDate('date', '>=', today())
                ->orderBy('date')
                ->orderBy('start_time')
                ->limit(6)
                ->get();
            $recentPatients = collect([$patient]);
        } else {
            $stats = [
                'patients' => Patient::count(),
                'staff' => Staff::count(),
                'appointments' => Appointment::whereDate('date', today())->count(),
                'outstanding' => Invoice::whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
                'medicines' => Medicine::count(),
            ];
            $upcomingAppointments = Appointment::with(['patient', 'doctor', 'department'])
                ->whereDate('date', '>=', today())
                ->orderBy('date')
                ->orderBy('start_time')
                ->limit(6)
                ->get();
            $recentPatients = Patient::latest()->limit(6)->get();
        }

        return view('dashboard.index', compact('user', 'stats', 'upcomingAppointments', 'recentPatients'));
    }
}
