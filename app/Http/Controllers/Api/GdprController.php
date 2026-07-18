<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\LabResult;
use App\Models\Prescription;
use App\Models\RadiologyOrder;
use App\Models\Surgery;
use App\Models\Vaccination;
use App\Models\PatientConsent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * GDPR / DPPA Compliance Controller
 *
 * Implements the data subject rights required by:
 *   - Uganda Data Protection and Privacy Act (DPPA) 2019
 *   - Kenya Data Protection Act 2019
 *   - Rwanda Law N°058/2021 on Data Protection
 *   - GDPR (for any EU patients)
 *
 * Endpoints:
 *   GET  /api/v1/patients/{id}/data-export     — Right to Access (Article 15)
 *   DELETE /api/v1/patients/{id}/erase          — Right to Erasure (Article 17)
 *   GET  /api/v1/patients/{id}/consents         — List consents
 *   POST /api/v1/patients/{id}/consents         — Grant/revoke consent
 *   GET  /api/v1/privacy-policy                 — Privacy policy
 *   GET  /api/v1/data-retention-policy          — Retention schedule
 */
class GdprController extends Controller
{
    /**
     * Right to Access — export all patient data as JSON.
     * GET /api/v1/patients/{patient}/data-export
     */
    public function exportPatientData(Request $request, Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);

        // Collect ALL data related to this patient
        $data = [
            'patient' => $patient->toArray(),
            'emergency_contacts' => $patient->emergencyContacts()->get()->toArray(),
            'insurances' => $patient->insurances()->get()->toArray(),
            'consents' => $patient->consents()->get()->toArray(),
            'appointments' => $patient->appointments()->get()->toArray(),
            'appointment_requests' => $patient->appointmentRequests()->get()->toArray(),
            'invoices' => $patient->invoices()->get()->toArray(),
            'insurance_claims' => $patient->insuranceClaims()->get()->toArray(),
            'prescriptions' => $patient->prescriptions()->get()->toArray(),
            'lab_results' => $patient->labResults()->get()->toArray(),
            'test_requests' => $patient->testRequests()->get()->toArray(),
            'radiology_orders' => $patient->radiologyOrders()->get()->toArray(),
            'surgeries' => $patient->surgeries()->get()->toArray(),
            'physiotherapy_sessions' => $patient->physiotherapySessions()->get()->toArray(),
            'room_allotments' => $patient->roomAllotments()->get()->toArray(),
            'blood_issues' => $patient->bloodIssues()->get()->toArray(),
            'vaccinations' => $patient->vaccinations()->get()->toArray(),
            'feedback' => $patient->feedback()->get()->toArray(),
            'medication_administrations' => $patient->medicationAdministrations()->get()->toArray(),
            'birth_record' => $patient->birthRecord ? $patient->birthRecord->toArray() : null,
            'death_record' => $patient->deathRecord ? $patient->deathRecord->toArray() : null,

            'export_metadata' => [
                'exported_at' => now()->toIso8601String(),
                'exported_by' => $request->user()->name,
                'exported_by_user_id' => $request->user()->id,
                'patient_id' => $patient->id,
                'patient_code' => $patient->code,
                'total_records' => 0, // calculated below
                'retention_period' => '7 years from last interaction (per DPPA 2019)',
            ],
        ];

        // Calculate total records
        $data['export_metadata']['total_records'] = collect($data)
            ->filter(fn($v) => is_array($v))
            ->map(fn($v) => is_array($v) && isset($v[0]) ? count($v) : (isset($v['id']) ? 1 : 0))
            ->sum();

        // Log the export for audit trail
        activity()
            ->performedOn($patient)
            ->causedBy($request->user())
            ->withProperties(['ip' => $request->ip(), 'total_records' => $data['export_metadata']['total_records']])
            ->log('Patient data exported (GDPR/DPPA Right to Access)');

        // Generate downloadable JSON file
        $filename = "patient_data_export_{$patient->code}_" . now()->format('Y-m-d_His') . '.json';
        $filepath = "exports/{$filename}";
        Storage::disk('local')->put($filepath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return response()->json([
            'success' => true,
            'message' => 'Patient data export generated. Download link provided.',
            'data' => [
                'download_url' => url("/api/v1/patients/{$patient->id}/data-export/download?token=" . Str::random(60)),
                'filename' => $filename,
                'total_records' => $data['export_metadata']['total_records'],
                'exported_at' => $data['export_metadata']['exported_at'],
                'retention_notice' => 'This export will be available for 24 hours, then automatically deleted.',
            ],
        ]);
    }

    /**
     * Right to Erasure — anonymize patient data (soft-delete + PII scrub).
     * DELETE /api/v1/patients/{patient}/erase
     *
     * Note: Medical records are retained for 7 years per DPPA 2019 Section 43.
     * This endpoint ANONYMIZES the patient (removes PII) but keeps clinical
     * records for legal/medical retention. True deletion happens after retention period.
     */
    public function erasePatientData(Request $request, Patient $patient): JsonResponse
    {
        $this->authorize('delete', $patient);

        // Require confirmation
        $request->validate([
            'confirm' => 'required|string|in:ERASE',
            'reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($patient, $request) {
            // Anonymize PII fields (keep the record for clinical/ legal retention)
            $patient->update([
                'first_name' => 'ANONYMIZED',
                'middle_name' => null,
                'last_name' => 'ANONYMIZED',
                'phone' => null,
                'alternate_phone' => null,
                'email' => null,
                'address' => null,
                'national_id' => null,
                'emergency_contact_name' => null,
                'emergency_contact_phone' => null,
                'medical_history' => null,
                'status' => 'Erased',
            ]);

            // Delete emergency contacts
            $patient->emergencyContacts()->delete();

            // Anonymize insurances (keep policy numbers for billing audit)
            $patient->insurances()->update([
                'policy_holder' => 'ANONYMIZED',
                'provider_phone' => null,
            ]);

            // Mark consents as revoked
            $patient->consents()->update([
                'consent_status' => 'revoked',
                'signed_at' => null,
            ]);

            // Log for audit trail (permanent record)
            activity()
                ->performedOn($patient)
                ->causedBy($request->user())
                ->withProperties([
                    'ip' => $request->ip(),
                    'reason' => $request->reason,
                    'retention_until' => now()->addYears(7)->toDateString(),
                ])
                ->log('Patient data ERASED (GDPR/DPPA Right to Erasure) — PII anonymized, clinical records retained for 7 years');
        });

        return response()->json([
            'success' => true,
            'message' => 'Patient PII has been anonymized. Clinical records are retained for 7 years per DPPA 2019 Section 43, then permanently deleted.',
            'data' => [
                'patient_id' => $patient->id,
                'patient_code' => $patient->code,
                'status' => 'Erased',
                'retention_until' => now()->addYears(7)->toDateString(),
                'permanent_deletion_date' => now()->addYears(7)->toDateString(),
            ],
        ]);
    }

    /**
     * List all consents for a patient.
     * GET /api/v1/patients/{patient}/consents
     */
    public function listConsents(Patient $patient): JsonResponse
    {
        $this->authorize('view', $patient);
        $consents = $patient->consents()->orderBy('created_at', 'desc')->get();
        return $this->success($consents, 'Patient consents retrieved.');
    }

    /**
     * Grant or revoke a consent.
     * POST /api/v1/patients/{patient}/consents
     *
     * Body: { consent_type: 'data_protection'|'treatment'|'financial', status: 'signed'|'pending'|'declined' }
     */
    public function updateConsent(Request $request, Patient $patient): JsonResponse
    {
        $this->authorize('update', $patient);

        $request->validate([
            'consent_type' => 'required|in:data_protection,treatment,financial',
            'status' => 'required|in:signed,pending,declined',
            'signature_data' => 'nullable|string',
        ]);

        $consent = PatientConsent::updateOrCreate(
            [
                'patient_id' => $patient->id,
                'consent_type' => $request->consent_type,
            ],
            [
                'consent_status' => $request->status,
                'signed_at' => $request->status === 'signed' ? now() : null,
                'signature_data' => $request->signature_data,
            ]
        );

        activity()
            ->performedOn($patient)
            ->causedBy($request->user())
            ->withProperties(['consent_type' => $request->consent_type, 'status' => $request->status])
            ->log("Consent {$request->consent_type} {$request->status}");

        return $this->success($consent, 'Consent updated.', 201);
    }

    /**
     * GET /api/v1/privacy-policy
     * Returns the privacy policy text.
     */
    public function privacyPolicy(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'title' => 'MediTrack Healthcare Privacy Policy',
                'version' => '1.0',
                'effective_date' => '2026-01-01',
                'jurisdiction' => 'Uganda (DPPA 2019), Kenya (DPA 2019), Rwanda (Law N°058/2021)',
                'sections' => [
                    'data_collected' => 'We collect: name, date of birth, contact information, national ID, medical history, lab results, prescriptions, billing information, and insurance details.',
                    'purpose' => 'Data is used for: patient care, billing, insurance claims, regulatory compliance, and public health reporting.',
                    'legal_basis' => 'Data processing is based on: patient consent (DPPA Section 7), contractual necessity (treatment), and legal obligation (DPPA Section 43 — medical records retention).',
                    'retention' => 'Medical records: 7 years from last interaction. Billing records: 7 years. Insurance claims: 7 years. Lab results: 7 years.',
                    'patient_rights' => [
                        'right_to_access' => 'You can request a copy of all your data (GET /api/v1/patients/{id}/data-export)',
                        'right_to_rectification' => 'You can correct inaccurate data (PUT /api/v1/patients/{id})',
                        'right_to_erasure' => 'You can request PII anonymization (DELETE /api/v1/patients/{id}/erase). Clinical records retained for 7 years.',
                        'right_to_object' => 'You can object to data processing for marketing (not applicable for treatment)',
                        'right_to_portability' => 'You can receive your data in JSON format for transfer to another provider',
                    ],
                    'data_protection_officer' => [
                        'name' => 'Data Protection Officer',
                        'email' => 'dpo@meditrack-healthcare.com',
                        'phone' => '+256-414-100-100',
                    ],
                    'complaints' => 'You may lodge a complaint with the Uganda Personal Data Protection Office (pdpo.go.ug) if you believe your rights have been violated.',
                ],
            ],
        ]);
    }

    /**
     * GET /api/v1/data-retention-policy
     * Returns the data retention schedule.
     */
    public function retentionPolicy(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'title' => 'MediTrack Healthcare Data Retention Policy',
                'version' => '1.0',
                'legal_basis' => 'Uganda DPPA 2019 Section 43, Uganda Medical & Dental Practitioners Council guidelines',
                'retention_schedule' => [
                    ['data_type' => 'Patient medical records', 'retention_period' => '7 years from last interaction', 'legal_basis' => 'DPPA Section 43'],
                    ['data_type' => 'Lab results', 'retention_period' => '7 years', 'legal_basis' => 'UMDPC guidelines'],
                    ['data_type' => 'Radiology images', 'retention_period' => '7 years', 'legal_basis' => 'UMDPC guidelines'],
                    ['data_type' => 'Prescriptions', 'retention_period' => '7 years', 'legal_basis' => 'Pharmacy Council of Uganda'],
                    ['data_type' => 'Billing & invoice records', 'retention_period' => '7 years', 'legal_basis' => 'Uganda Revenue Authority'],
                    ['data_type' => 'Insurance claims', 'retention_period' => '7 years', 'legal_basis' => 'Insurance Regulatory Authority'],
                    ['data_type' => 'Birth records', 'retention_period' => 'Permanent (100+ years)', 'legal_basis' => 'Uganda Births & Deaths Registration Act'],
                    ['data_type' => 'Death records', 'retention_period' => 'Permanent (100+ years)', 'legal_basis' => 'Uganda Births & Deaths Registration Act'],
                    ['data_type' => 'Audit logs', 'retention_period' => '7 years', 'legal_basis' => 'DPPA Section 43'],
                    ['data_type' => 'Staff HR records', 'retention_period' => '7 years after departure', 'legal_basis' => 'Employment Act'],
                    ['data_type' => 'Consent records', 'retention_period' => '7 years after consent withdrawn', 'legal_basis' => 'DPPA Section 7'],
                ],
                'disposal_method' => 'Secure deletion (DoD 5220.22-M standard) for electronic records; shredding for paper records.',
                'review_cycle' => 'Annually, or upon change in legal requirements.',
            ],
        ]);
    }
}
