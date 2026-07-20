<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrescriptionController extends Controller
{
    public function create(Request $request): View
    {
        $patients = Patient::orderBy('first_name')->orderBy('last_name')->get(['id', 'code', 'first_name', 'last_name']);
        $medicines = Medicine::orderBy('name')->get(['id', 'name', 'generic_name', 'code']);

        $selectedPatientId = $request->integer('patient_id') ?: null;
        $recentPrescriptions = collect();

        if ($selectedPatientId) {
            $recentPrescriptions = Prescription::where('patient_id', $selectedPatientId)
                ->latest('date')
                ->limit(5)
                ->get();
        }

        return view('prescriptions.create', compact('patients', 'medicines', 'selectedPatientId', 'recentPrescriptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'date' => ['required', 'date'],
            'refills' => ['nullable', 'integer', 'min:0', 'max:12'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.medicine_id' => ['nullable', 'exists:medicines,id'],
            'items.*.medication' => ['required', 'string', 'max:255'],
            'items.*.dosage' => ['required', 'string', 'max:50'],
            'items.*.frequency' => ['required', 'string', 'max:100'],
            'items.*.route' => ['required', 'string', 'max:30'],
            'items.*.duration' => ['nullable', 'integer', 'min:1'],
            'items.*.duration_unit' => ['nullable', 'string', 'max:10'],
            'items.*.instructions' => ['nullable', 'string', 'max:500'],
        ]);

        $doctorId = $request->user()->staff?->id;

        $prescription = Prescription::create([
            'code' => 'RX-' . str_pad((string) (Prescription::max('id') + 1), 5, '0', STR_PAD_LEFT),
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctorId,
            'date' => $validated['date'],
            'status' => 'Active',
            'refills' => $validated['refills'] ?? 0,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medication' => $item['medication'],
                'medicine_id' => $item['medicine_id'] ?? null,
                'dosage' => $item['dosage'],
                'frequency' => $item['frequency'],
                'route' => $item['route'],
                'duration' => $item['duration'] ?? null,
                'duration_unit' => $item['duration_unit'] ?? 'Days',
                'instructions' => $item['instructions'] ?? null,
            ]);
        }

        return redirect()
            ->route('dashboard')
            ->with('status', "Prescription {$prescription->code} created successfully.");
    }
}
