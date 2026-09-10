/**
 * Meditrack HMS — Consent Tracking Module
 * ============================================================
 * Wires the consent checkboxes in add-patient.html and edit-patient.html
 * to the GDPR consent API endpoints.
 *
 * When a patient is registered with consents checked, this module:
 *   1. Creates the patient via /api/v1/patients (or local store)
 *   2. For each checked consent, POST /api/v1/patients/{id}/consents
 *   3. Stores consent records locally for audit trail
 *
 * Consent types:
 *   - data_protection: DPPA Uganda 2019 / Kenya DPA 2019 / Rwanda Law N°058/2021
 *   - treatment: Informed consent for medical treatment
 *   - financial: Financial responsibility agreement
 */

(function(window, document) {
    'use strict';

    if (!window.MeditrackStore) return;
    const STORE = window.MeditrackStore;
    const Toast = window.Meditrack?.Toast;

    function init() {
        // Only run on patient registration/edit pages
        const page = (window.location.pathname.split('/').pop() || '').toLowerCase();
        if (!['add-patient.html', 'edit-patient.html', 'patient-profile.html'].includes(page)) return;

        // Find consent checkboxes/toggles
        const consentToggles = document.querySelectorAll('[data-consent-type], [data-consent]');
        consentToggles.forEach(toggle => {
            if (toggle.dataset.consentWired) return;
            toggle.dataset.consentWired = '1';

            toggle.addEventListener('click', () => {
                const consentType = toggle.getAttribute('data-consent-type') || toggle.getAttribute('data-consent');
                const isChecked = toggle.getAttribute('data-state') === 'checked' || toggle.checked;

                // Store locally for now (will sync to API when patient is saved)
                const consents = JSON.parse(localStorage.getItem('meditrack_pending_consents') || '{}');
                consents[consentType] = isChecked;
                localStorage.setItem('meditrack_pending_consents', JSON.stringify(consents));

                if (Toast) {
                    Toast.info(`${consentType.replace(/_/g, ' ')} consent ${isChecked ? 'granted' : 'revoked'}.`);
                }
            });
        });

        // Hook into patient form submission to save consents
        const patientForm = document.querySelector('form#addPatientForm, form[data-entity="patients"], form#editPatientForm');
        if (patientForm && !patientForm.dataset.consentHooked) {
            patientForm.dataset.consentHooked = '1';

            patientForm.addEventListener('submit', async (e) => {
                // Don't prevent default — let the normal handler run
                // Just hook in AFTER the patient is created

                // Wait a bit for the patient to be created
                setTimeout(async () => {
                    const consents = JSON.parse(localStorage.getItem('meditrack_pending_consents') || '{}');
                    const consentEntries = Object.entries(consents).filter(([_, v]) => v);

                    if (consentEntries.length === 0) return;

                    // Get the most recently created patient
                    const patients = STORE.list('patients') || [];
                    if (patients.length === 0) return;
                    const latestPatient = patients[patients.length - 1];

                    // Try API first
                    try {
                        for (const [consentType, _] of consentEntries) {
                            if (window.Meditrack?.api) {
                                await window.Meditrack.api('POST', `/patients/${latestPatient.id}/consents`, {
                                    consent_type: consentType,
                                    status: 'signed',
                                });
                            }
                        }
                    } catch (e) {
                        // API not available — store locally
                    }

                    // Store consent records locally
                    const allConsents = JSON.parse(localStorage.getItem('meditrack_consents') || '[]');
                    consentEntries.forEach(([consentType, _]) => {
                        allConsents.push({
                            patient_id: latestPatient.id,
                            patient_code: latestPatient.code,
                            consent_type: consentType,
                            consent_status: 'signed',
                            signed_at: new Date().toISOString(),
                            signed_by: window.Meditrack?.getCurrentUser()?.name || 'Unknown',
                        });
                    });
                    localStorage.setItem('meditrack_consents', JSON.stringify(allConsents));

                    // Clear pending consents
                    localStorage.removeItem('meditrack_pending_consents');

                    if (Toast && consentEntries.length > 0) {
                        Toast.success(`${consentEntries.length} consent(s) recorded for ${latestPatient.name || latestPatient.code}.`);
                    }
                }, 500);
            }, true); // capture phase
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    setTimeout(init, 1500);

})(window, document);
