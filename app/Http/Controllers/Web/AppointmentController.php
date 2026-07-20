<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Appointment::query()->with(['patient', 'doctor', 'department']);

        if ($request->user()->isPatient() && $request->user()->patient) {
            $query->where('patient_id', $request->user()->patient->getKey());
        }

        $search = $request->string('search')->trim()->value();
        $status = $request->string('status')->trim()->value();

        $query
            ->when($search, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->whereHas('patient', fn ($query) => $query
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%"));
                });
            })
            ->when($status, fn ($query, string $status) => $query->where('status', $status))
            ->when($request->date('date'), fn ($query, $date) => $query->whereDate('date', $date))
            ->orderByDesc('date')
            ->orderBy('start_time');

        $appointments = $query->paginate(15)->withQueryString();
        $scope = Appointment::query();

        if ($request->user()->isPatient() && $request->user()->patient) {
            $scope->where('patient_id', $request->user()->patient->getKey());
        }

        $stats = [
            'today' => (clone $scope)->whereDate('date', today())->count(),
            'upcoming' => (clone $scope)->whereDate('date', '>=', today())->count(),
            'pending' => (clone $scope)->where('status', 'Pending')->count(),
            'completed' => (clone $scope)->where('status', 'Completed')->count(),
        ];

        return view('appointments.index', compact('appointments', 'stats'));
    }
}
