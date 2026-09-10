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
use App\Services\DashboardAnalytics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
        $range = Validator::make([
            'from' => $request->input('from', $today->copy()->startOfMonth()->subMonths(5)->toDateString()),
            'to' => $request->input('to', $today->toDateString()),
        ], [
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d', 'after_or_equal:from'],
        ])->validate();
        $from = \Carbon\Carbon::parse($range['from'])->startOfDay();
        $to = \Carbon\Carbon::parse($range['to'])->endOfDay();
        if ($from->diffInDays($to->copy()->startOfDay()) > 366) {
            throw ValidationException::withMessages(['to' => 'Choose a reporting period of one year or less.']);
        }

        $stats = [
            'active_patients' => Patient::forCompany($user)->where('status', 'Active')->count(),
            'today_appointments' => Appointment::forCompany($user)->whereDate('date', $today)->count(),
            'staff' => Staff::forCompany($user)->where('status', 'Active')->count(),
            'outstanding' => Invoice::forCompany($user)->whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
            'monthly_revenue' => Invoice::forCompany($user)->where('status', 'Paid')
                ->whereMonth('payment_date', $today->month)
                ->whereYear('payment_date', $today->year)
                ->sum('paid_amount'),
        ];

        $upcomingAppointments = Appointment::forCompany($user)->with(['patient', 'doctor', 'department'])
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        $recentInvoices = Invoice::forCompany($user)->with('patient')->latest()->limit(8)->get();

        $appointmentStatus = Appointment::forCompany($user)->whereDate('date', $today)
            ->get(['status'])
            ->groupBy(fn (Appointment $appointment): string => $appointment->status ?: 'Pending')
            ->map(fn ($appointments): int => $appointments->count())
            ->sortDesc();

        // Aggregate the real reporting period for the reference dashboard chart.
        $chart = collect(\Carbon\CarbonPeriod::create($from->copy()->startOfMonth(), '1 month', $to))
            ->map(function ($month) use ($from, $to, $user): array {
            $start = $month->copy()->max($from);
            $end = $month->copy()->endOfMonth()->min($to);

            return [
                'month' => $month->format('M Y'),
                'revenue' => (float) Invoice::forCompany($user)->where('status', 'Paid')
                    ->whereDate('payment_date', '>=', $start->toDateString())
                    ->whereDate('payment_date', '<=', $end->toDateString())->sum('paid_amount'),
                'visits' => Appointment::forCompany($user)->whereDate('date', '>=', $start->toDateString())
                    ->whereDate('date', '<=', $end->toDateString())->count(),
            ];
        });
        $analytics = app(DashboardAnalytics::class)->forPeriod($from, $to, $user);
        $dashboardNotifications = \App\Models\Notification::where('user_id', $user->id)->latest()->limit(12)->get();

        return view('dashboard.admin', compact(
            'user',
            'currency',
            'stats',
            'upcomingAppointments',
            'recentInvoices',
            'appointmentStatus',
            'chart',
            'dashboardNotifications',
            'analytics',
            'from',
            'to'
        ));
    }

    public function doctor(Request $request): View
    {
        $user = $request->user();
        $staffId = $user->staff?->id;
        $today = today();

        $stats = [
            'today' => Appointment::forCompany($user)->where('doctor_id', $staffId)->whereDate('date', $today)->count(),
            'upcoming' => Appointment::forCompany($user)->where('doctor_id', $staffId)->whereDate('date', '>=', $today)->count(),
            'patients' => Appointment::forCompany($user)->where('doctor_id', $staffId)->distinct('patient_id')->count('patient_id'),
            'prescriptions' => Prescription::forCompany($user)->where('doctor_id', $staffId)->where('status', 'Active')->count(),
        ];

        $todaysAppointments = Appointment::forCompany($user)->with(['patient', 'department'])
            ->where('doctor_id', $staffId)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        $recentPrescriptions = Prescription::forCompany($user)->with('patient')
            ->where('doctor_id', $staffId)
            ->latest('date')
            ->limit(6)
            ->get();

        $pendingLabRequests = TestRequest::forCompany($user)->with('patient')
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

        $appointmentsQuery = Appointment::query()->forCompany($user)->whereDate('date', $today);
        if ($departmentId) {
            $appointmentsQuery->where('department_id', $departmentId);
        }

        $stats = [
            'today_appointments' => (clone $appointmentsQuery)->count(),
            'active_patients' => Patient::forCompany($user)->where('status', 'Active')->count(),
            'on_duty_staff' => Staff::forCompany($user)->where('status', 'Active')
                ->when($departmentId, fn ($query) => $query->where('department_id', $departmentId))
                ->count(),
            'urgent_lab_requests' => TestRequest::forCompany($user)->where('priority', 'Urgent')
                ->whereNotIn('status', ['Completed', 'Cancelled'])
                ->count(),
        ];

        $todaysAppointments = (clone $appointmentsQuery)
            ->with(['patient', 'doctor'])
            ->orderBy('start_time')
            ->limit(8)
            ->get();

        $recentPatients = Patient::forCompany($user)->latest()->limit(6)->get();

        return view('dashboard.nurse', compact('user', 'stats', 'todaysAppointments', 'recentPatients'));
    }

    public function receptionist(Request $request): View
    {
        $user = $request->user();
        $today = today();

        $stats = [
            'today_appointments' => Appointment::forCompany($user)->whereDate('date', $today)->count(),
            'pending_confirmation' => Appointment::forCompany($user)->whereDate('date', $today)->where('status', 'Pending')->count(),
            'new_patients_week' => Patient::forCompany($user)->where('created_at', '>=', now()->subDays(7))->count(),
            'active_patients' => Patient::forCompany($user)->where('status', 'Active')->count(),
        ];

        $todaysAppointments = Appointment::forCompany($user)->with(['patient', 'doctor', 'department'])
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get();

        $recentPatients = Patient::forCompany($user)->latest()->limit(8)->get();

        return view('dashboard.receptionist', compact('stats', 'todaysAppointments', 'recentPatients'));
    }

    public function lab(Request $request): View
    {
        $user = $request->user();
        $requests = TestRequest::forCompany($user)->with(['patient', 'doctor'])->latest('requested_date')->limit(8)->get();
        $results = LabResult::forCompany($user)->with('patient')->latest('result_date')->limit(8)->get();

        $stats = [
            'pending_requests' => TestRequest::forCompany($user)->whereIn('status', ['Pending', 'In Progress'])->count(),
            'ready_results' => LabResult::forCompany($user)->whereIn('status', ['Completed', 'Verified'])->count(),
            'urgent' => TestRequest::forCompany($user)->where('priority', 'Urgent')->whereNotIn('status', ['Completed', 'Cancelled'])->count(),
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
        $recentPrescriptions = Prescription::forCompany($request->user())->with(['patient', 'doctor'])
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
            return view('dashboard.patient', [
                'user' => $user,
                'stats' => ['appointments' => 0, 'prescriptions' => 0, 'lab_results' => 0, 'outstanding' => 0],
                'upcomingAppointments' => collect(),
                'recentPrescriptions' => collect(),
                'recentLabResults' => collect(),
                'invoices' => collect(),
            ]);
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
        $user = $request->user();
        $today = today();

        $stats = [
            'outstanding' => Invoice::forCompany($user)->whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
            'paid_this_month' => Invoice::forCompany($user)->where('status', 'Paid')
                ->whereMonth('payment_date', $today->month)
                ->whereYear('payment_date', $today->year)
                ->sum('amount'),
            'overdue' => Invoice::forCompany($user)->where('status', 'Overdue')->count(),
            'pending_claims' => InsuranceClaim::forCompany($user)->whereNotIn('status', ['Approved', 'Rejected', 'Paid'])->count(),
        ];

        $recentInvoices = Invoice::forCompany($user)->with('patient')->latest()->limit(8)->get();
        $recentClaims = InsuranceClaim::forCompany($user)->with('patient')->latest('submitted_date')->limit(8)->get();

        return view('dashboard.finance', compact('currency', 'stats', 'recentInvoices', 'recentClaims'));
    }

    public function general(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'patients' => Patient::forCompany($user)->count(),
            'staff' => Staff::forCompany($user)->count(),
            'appointments' => Appointment::forCompany($user)->whereDate('date', today())->count(),
            'outstanding' => Invoice::forCompany($user)->whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
            'medicines' => Medicine::count(),
        ];

        $upcomingAppointments = Appointment::forCompany($user)->with(['patient', 'doctor', 'department'])
            ->whereDate('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        $recentPatients = Patient::forCompany($user)->latest()->limit(6)->get();

        return view('dashboard.index', compact('user', 'stats', 'upcomingAppointments', 'recentPatients'));
    }
}
