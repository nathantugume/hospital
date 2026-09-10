<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LabResult;
use App\Models\LabTest;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\TestRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LabController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', TestRequest::class);
        $patientId = $request->user()->isPatient() ? $request->user()->patient?->getKey() : null;
        $requests = TestRequest::query()->forCompany($request->user())->with(['patient', 'doctor']);
        $results = LabResult::query()->forCompany($request->user())->with('patient');

        if ($patientId) {
            $requests->where('patient_id', $patientId);
            $results->where('patient_id', $patientId);
        }

        $requests = $requests->latest('requested_date')->limit(8)->get();
        $results = $results->latest('result_date')->limit(8)->get();
        $statsQuery = TestRequest::query()->forCompany($request->user());
        $resultQuery = LabResult::query()->forCompany($request->user());

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
        $this->authorize('viewAny', TestRequest::class);
        $patientId = $request->user()->isPatient() ? $request->user()->patient?->getKey() : null;

        $query = TestRequest::query()->forCompany($request->user())->with(['patient', 'doctor']);

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

        $statsQuery = TestRequest::query()->forCompany($request->user());
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

    public function createRequest(Request $request): View
    {
        $this->authorize('create', TestRequest::class);

        return view('laboratory.create-request', [
            'patients' => Patient::forCompany($request->user())->where('status', 'Active')->orderBy('first_name')->get(['id', 'first_name', 'last_name', 'code']),
            'doctors' => Staff::forCompany($request->user())->whereNotNull('specialization')->where('status', 'Active')->orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'labTests' => LabTest::where('status', 'Active')->orderBy('department')->orderBy('name')->get(),
        ]);
    }

    public function storeRequest(Request $request): RedirectResponse
    {
        $this->authorize('create', TestRequest::class);
        $data = $request->validate([
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'doctor_id' => ['nullable', 'integer', 'exists:staff,id'],
            'lab_test_ids' => ['required', 'array', 'min:1'],
            'lab_test_ids.*' => ['integer', Rule::exists('lab_tests', 'id')->where('status', 'Active')],
            'priority' => ['required', Rule::in(['Routine', 'Urgent', 'STAT'])],
            'requested_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
        abort_unless(Patient::forCompany($request->user())->whereKey($data['patient_id'])->exists(), 403);
        if (! empty($data['doctor_id'])) { abort_unless(Staff::forCompany($request->user())->whereKey($data['doctor_id'])->exists(), 403); }

        $testRequest = DB::transaction(function () use ($data): TestRequest {
            $record = TestRequest::create([
                'code' => 'TR-' . strtoupper(substr((string) str()->uuid(), 0, 8)),
                'patient_id' => $data['patient_id'], 'doctor_id' => $data['doctor_id'] ?? null,
                'priority' => $data['priority'], 'status' => 'Pending',
                'requested_date' => $data['requested_date'], 'notes' => $data['notes'] ?? null,
            ]);
            $record->labTests()->sync($data['lab_test_ids']);
            return $record;
        });

        return redirect()->route('web.laboratory.requests.show', $testRequest)->with('status', 'Test request created successfully.');
    }

    public function showRequest(TestRequest $testRequest): View
    {
        $this->authorize('view', $testRequest);
        $testRequest->load(['patient', 'doctor', 'labTests']);
        return view('laboratory.show-request', compact('testRequest'));
    }

    public function collectSample(Request $request, TestRequest $testRequest): RedirectResponse
    {
        $this->authorize('update', $testRequest);
        abort_unless($request->user()->hasRole(['admin', 'super_admin', 'nurse', 'lab_technician']), 403);
        $data = $request->validate(['collection_date' => ['required', 'date', 'before_or_equal:today'], 'sample_id' => ['required', 'string', 'max:18']]);

        DB::transaction(function () use ($testRequest, $data): void {
            $locked = TestRequest::query()->lockForUpdate()->findOrFail($testRequest->id);
            abort_unless($locked->status === 'Pending', 409, 'Only pending requests can have samples collected.');
            $locked->load('labTests');
            foreach ($locked->labTests as $index => $labTest) {
                LabResult::firstOrCreate(
                    ['test_request_id' => $locked->id, 'lab_test_id' => $labTest->id],
                    ['code' => 'LR-' . strtoupper(substr((string) str()->uuid(), 0, 8)), 'sample_id' => $data['sample_id'] . '-' . ($index + 1), 'patient_id' => $locked->patient_id, 'test_name' => $labTest->name, 'result_date' => $data['collection_date'], 'collection_date' => $data['collection_date'], 'status' => 'Pending', 'flag' => 'Normal', 'ordered_by' => $locked->doctor_id, 'sample_type' => $labTest->sample_type, 'department' => $labTest->department]
                );
            }
            $locked->update(['status' => 'Sample Collected']);
        });

        return back()->with('status', 'Sample collection recorded.');
    }

    public function results(Request $request): View
    {
        $this->authorize('viewAny', LabResult::class);
        $results = LabResult::forCompany($request->user())->with(['patient', 'labTest', 'verifiedBy'])
            ->when($request->string('status')->trim()->value(), fn ($q, $status) => $q->where('status', $status))
            ->when($request->string('search')->trim()->value(), fn ($q, $search) => $q->where(fn ($q) => $q->where('code', 'like', "%{$search}%")->orWhere('sample_id', 'like', "%{$search}%")->orWhereHas('patient', fn ($p) => $p->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"))))
            ->latest('collection_date')->paginate(20)->withQueryString();
        return view('laboratory.results', compact('results'));
    }

    public function editResult(Request $request, LabResult $labResult): View
    {
        $this->authorize('update', $labResult);
        abort_unless($request->user()->hasRole(['admin', 'super_admin', 'lab_technician']), 403);
        abort_unless(in_array($labResult->status, ['Pending', 'In Progress'], true), 409);
        $labResult->load(['patient', 'labTest', 'testRequest']);
        return view('laboratory.edit-result', compact('labResult'));
    }

    public function updateResult(Request $request, LabResult $labResult): RedirectResponse
    {
        $this->authorize('update', $labResult);
        abort_unless($request->user()->hasRole(['admin', 'super_admin', 'lab_technician']), 403);
        $data = $request->validate(['result_value' => ['required', 'string', 'max:100'], 'normal_range' => ['nullable', 'string', 'max:100'], 'unit' => ['nullable', 'string', 'max:50'], 'flag' => ['required', Rule::in(['Normal', 'High', 'Low', 'Critical'])], 'notes' => ['nullable', 'string', 'max:4000']]);
        DB::transaction(function () use ($labResult, $data): void {
            $locked = LabResult::query()->lockForUpdate()->findOrFail($labResult->id);
            abort_unless(in_array($locked->status, ['Pending', 'In Progress'], true), 409, 'Verified or completed results cannot be edited.');
            $locked->update($data + ['status' => 'Completed', 'result_date' => today()]);
            if ($locked->test_request_id) {
                $remaining = LabResult::where('test_request_id', $locked->test_request_id)->whereNotIn('status', ['Completed', 'Verified'])->exists();
                TestRequest::whereKey($locked->test_request_id)->update(['status' => $remaining ? 'In Progress' : 'Completed']);
            }
        });
        return redirect()->route('web.laboratory.results')->with('status', 'Lab result completed.');
    }

    public function verifyResult(Request $request, LabResult $labResult): RedirectResponse
    {
        $this->authorize('update', $labResult);
        abort_unless($request->user()->hasRole(['admin', 'super_admin', 'doctor', 'lab_technician']), 403);
        abort_unless($request->user()->staff_id !== null, 422, 'A linked staff record is required to verify results.');
        DB::transaction(function () use ($labResult, $request): void {
            $locked = LabResult::query()->lockForUpdate()->findOrFail($labResult->id);
            abort_unless($locked->status === 'Completed' && filled($locked->result_value), 409, 'Only completed results with a value can be verified.');
            $locked->update(['status' => 'Verified', 'verified_by' => $request->user()->staff_id, 'verified_date' => now()]);
        });
        $verified = $labResult->fresh();
        if (in_array($verified->flag, ['High', 'Low', 'Critical'], true)) { event(new \App\Events\AbnormalLabResult($verified)); }
        return back()->with('status', 'Lab result verified.');
    }

    public function uploadAttachment(Request $request, LabResult $labResult): RedirectResponse
    {
        $this->authorize('update', $labResult);
        abort_unless($request->user()->hasRole(['admin', 'super_admin', 'lab_technician']), 403);
        $request->validate(['attachment' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240']]);
        $oldPath = $labResult->attachment_url;
        $path = $request->file('attachment')->store("lab-results/{$labResult->id}", 'local');
        $labResult->update(['attachment_url' => $path]);
        if ($oldPath && $oldPath !== $path) { Storage::disk('local')->delete($oldPath); }
        return back()->with('status', 'Result attachment uploaded.');
    }

    public function downloadAttachment(LabResult $labResult)
    {
        $this->authorize('view', $labResult);
        abort_unless($labResult->attachment_url && Storage::disk('local')->exists($labResult->attachment_url), 404);
        return Storage::disk('local')->download($labResult->attachment_url);
    }

    public function shareResult(Request $request, LabResult $labResult): RedirectResponse
    {
        $this->authorize('view', $labResult);
        abort_unless($labResult->status === 'Verified', 409, 'Only verified results can be shared.');
        $token = str()->random(64);
        $expiresAt = now()->addDays(7);
        $labResult->update(['share_token' => hash('sha256', $token), 'share_expires_at' => $expiresAt]);
        $url = URL::temporarySignedRoute('share.lab-result', $expiresAt, ['token' => $token]);
        return back()->with('status', 'Secure result link created.')->with('share_url', $url);
    }

    public function revokeShare(LabResult $labResult): RedirectResponse
    {
        $this->authorize('view', $labResult);
        $labResult->update(['share_token' => null, 'share_expires_at' => null]);
        return back()->with('status', 'Shared result link revoked.');
    }
}
