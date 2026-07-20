<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LabResult;
use App\Models\LabTest;
use App\Models\TestRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LabController extends Controller
{
    public function index(Request $request): View
    {
        $patientId = $request->user()->isPatient() ? $request->user()->patient?->getKey() : null;
        $requests = TestRequest::query()->with(['patient', 'doctor']);
        $results = LabResult::query()->with('patient');

        if ($patientId) {
            $requests->where('patient_id', $patientId);
            $results->where('patient_id', $patientId);
        }

        $requests = $requests->latest('requested_date')->limit(8)->get();
        $results = $results->latest('result_date')->limit(8)->get();
        $statsQuery = TestRequest::query();
        $resultQuery = LabResult::query();

        if ($patientId) {
            $statsQuery->where('patient_id', $patientId);
            $resultQuery->where('patient_id', $patientId);
        }

        $stats = [
            'pending_requests' => (clone $statsQuery)->whereIn('status', ['Pending', 'In Progress'])->count(),
            'ready_results' => (clone $resultQuery)->whereIn('status', ['Completed', 'Verified'])->count(),
            'urgent' => (clone $statsQuery)->where('priority', 'Urgent')->whereNotIn('status', ['Completed', 'Cancelled'])->count(),
            'catalogue' => LabTest::where('status', 'Active')->count(),
        ];

        return view('laboratory.index', compact('requests', 'results', 'stats'));
    }

    public function requests(Request $request): View
    {
        $patientId = $request->user()->isPatient() ? $request->user()->patient?->getKey() : null;

        $query = TestRequest::query()->with(['patient', 'doctor']);

        if ($patientId) {
            $query->where('patient_id', $patientId);
        }

        $status = $request->string('status')->trim()->value();

        $query
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhereHas('patient', fn ($query) => $query
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%"));
                });
            })
            ->when($status, fn ($query, string $status) => $query->where('status', $status))
            ->orderByDesc('requested_date');

        $testRequests = $query->paginate(15)->withQueryString();

        $statsQuery = TestRequest::query();
        if ($patientId) {
            $statsQuery->where('patient_id', $patientId);
        }

        $stats = [
            'pending' => (clone $statsQuery)->where('status', 'Pending')->count(),
            'in_progress' => (clone $statsQuery)->where('status', 'In Progress')->count(),
            'completed' => (clone $statsQuery)->where('status', 'Completed')->count(),
            'cancelled' => (clone $statsQuery)->where('status', 'Cancelled')->count(),
        ];

        return view('laboratory.requests', compact('testRequests', 'stats', 'status'));
    }
}
