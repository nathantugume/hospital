<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\InsuranceClaim;
use App\Models\Invoice;
use App\Models\LabResult;
use App\Models\LabTest;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Staff;
use App\Models\TestRequest;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request, CurrencyService $currency): View
    {
        $user = $request->user();

        return match (true) {
            $user->isAdmin() => $this->admin($request, $currency),
            $user->isDoctor() => $this->doctor($request),
            $user->isNurse() => $this->nurse($request),
            $user->isReceptionist() => $this->receptionist($request),
            $user->isLabTech() => $this->lab($request),
            $user->isPharmacist() => $this->pharmacist($request),
            $user->isPatient() => $this->patient($request),
            $user->isAccountant(), $user->isInsuranceOfficer() => $this->finance($request, $currency),
            default => $this->general($request),
        };
    }

    public function admin(Request $request, CurrencyService $currency): View
    {
        $user = $request->user();
        $today = today();

        $stats = [
            'active_patients' => Patient::where('status', 'Active')->count(),
            'today_appointments' => Appointment::whereDate('date', $today)->count(),
            'staff' => Staff::where('status', 'Active')->count(),
            'outstanding' => Invoice::whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
            'monthly_revenue' => Invoice::where('status', 'Paid')
                ->whereMonth('payment_date', $today->month)
                ->whereYear('payment_date', $today->year)
                ->sum('paid_amount'),
        ];

        $upcomingAppointments = Appointment::with(['patient', 'doctor', 'department'])
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        $recentInvoices = Invoice::with('patient')->latest()->limit(8)->get();

        $appointmentStatus = Appointment::whereDate('date', $today)
            ->get(['status'])
            ->groupBy(fn (Appointment $appointment): string => $appointment->status ?: 'Pending')
            ->map(fn ($appointments): int => $appointments->count())
            ->sortDesc();

        return view('dashboard.admin', compact(
            'user',
            'currency',
            'stats',
            'upcomingAppointments',
            'recentInvoices',
            'appointmentStatus'
        ));
    }

    public function doctor(Request $request): View
    {
        $user = $request->user();
        $staffId = $user->staff?->id;
        $today = today();

        $stats = [
            'today' => Appointment::where('doctor_id', $staffId)->whereDate('date', $today)->count(),
            'upcoming' => Appointment::where('doctor_id', $staffId)->whereDate('date', '>=', $today)->count(),
            'patients' => Appointment::where('doctor_id', $staffId)->distinct('patient_id')->count('patient_id'),
            'prescriptions' => Prescription::where('doctor_id', $staffId)->where('status', 'Active')->count(),
        ];

        $todaysAppointments = Appointment::with(['patient', 'department'])
            ->where('doctor_id', $staffId)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        $recentPrescriptions = Prescription::with('patient')
            ->where('doctor_id', $staffId)
            ->latest('date')
            ->limit(6)
            ->get();

        $pendingLabRequests = TestRequest::with('patient')
            ->where('doctor_id', $staffId)
            ->whereIn('status', ['Pending', 'In Progress'])
            ->latest('requested_date')
            ->limit(6)
            ->get();

        return view('dashboard.doctor', compact(
            'user',
            'stats',
            'todaysAppointments',
            'recentPrescriptions',
            'pendingLabRequests'
        ));
    }

    public function nurse(Request $request): View
    {
        $user = $request->user();
        $departmentId = $user->staff?->department_id;
        $today = today();

        $appointmentsQuery = Appointment::query()->whereDate('date', $today);
        if ($departmentId) {
            $appointmentsQuery->where('department_id', $departmentId);
        }

        $stats = [
            'today_appointments' => (clone $appointmentsQuery)->count(),
            'active_patients' => Patient::where('status', 'Active')->count(),
            'on_duty_staff' => Staff::where('status', 'Active')
                ->when($departmentId, fn ($query) => $query->where('department_id', $departmentId))
                ->count(),
            'urgent_lab_requests' => TestRequest::where('priority', 'Urgent')
                ->whereNotIn('status', ['Completed', 'Cancelled'])
                ->count(),
        ];

        $todaysAppointments = (clone $appointmentsQuery)
            ->with(['patient', 'doctor'])
            ->orderBy('start_time')
            ->limit(8)
            ->get();

        $recentPatients = Patient::latest()->limit(6)->get();

        return view('dashboard.nurse', compact('user', 'stats', 'todaysAppointments', 'recentPatients'));
    }

    public function receptionist(Request $request): View
    {
        $today = today();

        $stats = [
            'today_appointments' => Appointment::whereDate('date', $today)->count(),
            'pending_confirmation' => Appointment::whereDate('date', $today)->where('status', 'Pending')->count(),
            'new_patients_week' => Patient::where('created_at', '>=', now()->subDays(7))->count(),
            'active_patients' => Patient::where('status', 'Active')->count(),
        ];

        $todaysAppointments = Appointment::with(['patient', 'doctor', 'department'])
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        $recentPatients = Patient::latest()->limit(8)->get();

        return view('dashboard.receptionist', compact('stats', 'todaysAppointments', 'recentPatients'));
    }

    public function lab(Request $request): View
    {
        $requests = TestRequest::with(['patient', 'doctor'])->latest('requested_date')->limit(8)->get();
        $results = LabResult::with('patient')->latest('result_date')->limit(8)->get();

        $stats = [
            'pending_requests' => TestRequest::whereIn('status', ['Pending', 'In Progress'])->count(),
            'ready_results' => LabResult::whereIn('status', ['Completed', 'Verified'])->count(),
            'urgent' => TestRequest::where('priority', 'Urgent')->whereNotIn('status', ['Completed', 'Cancelled'])->count(),
            'catalogue' => LabTest::where('status', 'Active')->count(),
        ];

        return view('dashboard.lab', compact('requests', 'results', 'stats'));
    }

    public function pharmacist(Request $request): View
    {
        $stats = [
            'catalogue' => Medicine::count(),
            'low_stock' => Medicine::whereColumn('stock', '<=', 'reorder_level')->count(),
            'out_of_stock' => Medicine::where('stock', '<=', 0)->count(),
            'expiring' => Medicine::whereNotNull('expiry')->whereBetween('expiry', [today(), today()->addDays(90)])->count(),
        ];

        $lowStockMedicines = Medicine::whereColumn('stock', '<=', 'reorder_level')->orderBy('stock')->limit(6)->get();
        $recentPrescriptions = Prescription::with(['patient', 'doctor'])
            ->where('status', 'Active')
            ->latest('date')
            ->limit(6)
            ->get();

        return view('dashboard.pharmacist', compact('stats', 'lowStockMedicines', 'recentPrescriptions'));
    }

    public function patient(Request $request): View
    {
        $user = $request->user();
        $patient = $user->patient;

        if (! $patient) {
            return $this->general($request);
        }

        $stats = [
            'appointments' => $patient->appointments()->whereDate('date', today())->count(),
            'prescriptions' => $patient->prescriptions()->where('status', 'Active')->count(),
            'lab_results' => $patient->labResults()->count(),
            'outstanding' => $patient->invoices()->sum('balance'),
        ];

        $upcomingAppointments = $patient->appointments()
            ->with(['doctor', 'department'])
            ->whereDate('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        $recentPrescriptions = $patient->prescriptions()->with('doctor')->latest('date')->limit(6)->get();
        $recentLabResults = $patient->labResults()->latest('result_date')->limit(6)->get();
        $invoices = $patient->invoices()->latest()->limit(6)->get();

        return view('dashboard.patient', compact(
            'user',
            'stats',
            'upcomingAppointments',
            'recentPrescriptions',
            'recentLabResults',
            'invoices'
        ));
    }

    public function finance(Request $request, CurrencyService $currency): View
    {
        $today = today();

        $stats = [
            'outstanding' => Invoice::whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
            'paid_this_month' => Invoice::where('status', 'Paid')
                ->whereMonth('payment_date', $today->month)
                ->whereYear('payment_date', $today->year)
                ->sum('amount'),
            'overdue' => Invoice::where('status', 'Overdue')->count(),
            'pending_claims' => InsuranceClaim::whereNotIn('status', ['Approved', 'Rejected', 'Paid'])->count(),
        ];

        $recentInvoices = Invoice::with('patient')->latest()->limit(8)->get();
        $recentClaims = InsuranceClaim::with('patient')->latest('submitted_date')->limit(8)->get();

        return view('dashboard.finance', compact('currency', 'stats', 'recentInvoices', 'recentClaims'));
    }

    public function general(Request $request): View
    {
        $user = $request->user();

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

        return view('dashboard.index', compact('user', 'stats', 'upcomingAppointments', 'recentPatients'));
    }
}
