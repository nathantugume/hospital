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
}
