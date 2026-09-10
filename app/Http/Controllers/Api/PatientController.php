<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patients\StorePatientRequest;
use App\Http\Requests\Patients\UpdatePatientRequest;
use App\Http\Resources\Patient\Resource;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Patient::class);

        $query = Patient::query()->forCompany($request->user())->with(['company', 'insurances', 'emergencyContacts']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }

        if ($bloodType = $request->input('blood_type')) {
            $query->where('blood_type', $bloodType);
        }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Patient list retrieved.',
            'data' => Resource::collection($items->items()),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
            ],
            'links' => [
                'first' => $items->url(1),
                'last' => $items->url($items->lastPage()),
                'prev' => $items->previousPageUrl(),
                'next' => $items->nextPageUrl(),
            ],
        ]);
    }

    public function store(StorePatientRequest $request): JsonResponse
    {
        $this->authorize('create', Patient::class);
        $data = $request->validated();
        $data['company_id'] = $request->user()->company_id;

        if (empty($data['code'])) {
            $data['code'] = 'P-' . str_pad((string) (Patient::max('id') + 1), 5, '0', STR_PAD_LEFT);
        }

        $patient = Patient::create($data);

        event(new \App\Events\PatientRegistered($patient));

        return $this->resource(new Resource($patient), 'Patient created.', 201);
    }

    public function show(Request $request, Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);
        $patient->load(['company', 'insurances', 'emergencyContacts', 'consents',
                         'appointments' => fn($q) => $q->latest()->limit(10),
                         'labResults' => fn($q) => $q->latest()->limit(10),
                         'prescriptions' => fn($q) => $q->latest()->limit(10),
                         'invoices' => fn($q) => $q->latest()->limit(10)]);
        return $this->resource(new Resource($patient));
    }

    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $this->authorize('update', $patient);
        $patient->update($request->validated());
        return $this->resource(new Resource($patient), 'Patient updated.');
    }

    public function destroy(Request $request, Patient $patient): JsonResponse
    {
        $this->authorize('delete', $patient);
        $patient->delete();
        return response()->json(['success' => true, 'message' => 'Patient deleted.'], 200);
    }

    public function appointments(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);
        $appointments = $patient->appointments()->with(['doctor', 'department'])->latest()->paginate(15);
        return response()->json(['success' => true, 'data' => $appointments]);
    }

    public function labResults(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);
        $results = $patient->labResults()->with(['labTest', 'orderedBy', 'verifiedBy'])->latest()->paginate(15);
        return response()->json(['success' => true, 'data' => $results]);
    }

    public function prescriptions(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);
        $prescriptions = $patient->prescriptions()->with(['doctor', 'items.medicine'])->latest()->paginate(15);
        return response()->json(['success' => true, 'data' => $prescriptions]);
    }

    public function invoices(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);
        $invoices = $patient->invoices()->with(['items', 'insuranceClaims'])->latest()->paginate(15);
        return response()->json(['success' => true, 'data' => $invoices]);
    }
}
