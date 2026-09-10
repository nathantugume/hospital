<?php

namespace Tests\Feature\Web;

use App\Models\Appointment;
use App\Models\AppointmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class AppointmentPhaseTwoTest extends TestCase
{
    public function test_patient_request_uses_the_linked_patients_company_and_staff_can_approve_it(): void
    {
        [$company, $patient, $doctor] = $this->context();
        $patientUser = User::factory()->patient()->create([
            'company_id' => null,
            'patient_id' => $patient->id,
        ]);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);

        $this->actingAs($patientUser)->get(route('web.appointment-requests.create'))
            ->assertOk()
            ->assertSee($doctor->full_name);

        $this->actingAs($patientUser)->post(route('web.appointment-requests.store'), [
            'doctor_id' => $doctor->id,
            'requested_date' => today()->addDays(3)->toDateString(),
            'requested_time' => '11:00',
            'type' => 'Consultation',
            'notes' => 'Persistent headache',
        ])->assertRedirect(route('web.appointment-requests.index'));

        $appointmentRequest = AppointmentRequest::where('patient_id', $patient->id)->firstOrFail();
        $this->assertSame($company->id, $appointmentRequest->company_id);

        $this->actingAs($admin)->patch(route('web.appointment-requests.process', $appointmentRequest), [
            'decision' => 'Approved',
        ])->assertRedirect();

        $this->assertSame('Approved', $appointmentRequest->fresh()->status);
        $this->assertDatabaseHas('appointments', [
            'company_id' => $company->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'status' => 'Confirmed',
        ]);
    }

    public function test_patient_and_doctor_only_see_their_own_or_assigned_appointments(): void
    {
        [$company, $patient, $doctor] = $this->context();
        $otherPatient = Patient::factory()->create(['company_id' => $company->id, 'first_name' => 'HiddenPatient']);
        $otherDoctor = $this->doctor($company, 'ST-PHASE2-B', 'HiddenDoctor');
        $patientUser = User::factory()->patient()->create(['company_id' => $company->id, 'patient_id' => $patient->id]);
        $doctorUser = User::factory()->doctor()->create(['company_id' => $company->id, 'staff_id' => $doctor->id]);
        $own = $this->appointment($company, $patient, $doctor, '09:00');
        $other = $this->appointment($company, $otherPatient, $otherDoctor, '10:00');

        $this->actingAs($patientUser)->get(route('web.appointments.index'))
            ->assertOk()->assertSee($patient->first_name)->assertDontSee('HiddenPatient');
        $this->actingAs($patientUser)->get(route('web.appointments.show', $other))->assertForbidden();

        $this->actingAs($doctorUser)->get(route('web.appointments.index'))
            ->assertOk()->assertSee($patient->first_name)->assertDontSee('HiddenPatient');
        $this->actingAs($doctorUser)->get(route('web.appointments.show', $other))->assertForbidden();
        $this->actingAs($doctorUser)->get(route('web.appointments.show', $own))->assertOk();
    }

    public function test_day_week_and_month_calendar_views_use_database_records(): void
    {
        [$company, $patient, $doctor] = $this->context();
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $appointment = $this->appointment($company, $patient, $doctor, '09:00', today()->addDays(2));

        foreach (['month', 'week', 'day'] as $view) {
            $this->actingAs($admin)->get(route('web.appointments.calendar', [
                'view' => $view,
                'date' => $appointment->date->toDateString(),
            ]))->assertOk()->assertSee($patient->full_name);
        }
    }

    public function test_status_transitions_are_enforced_and_legacy_detail_routes_redirect(): void
    {
        [$company, $patient, $doctor] = $this->context();
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $appointment = $this->appointment($company, $patient, $doctor, '09:00');

        $this->actingAs($admin)->patch(route('web.appointments.status', $appointment), ['status' => 'Completed'])
            ->assertSessionHasErrors('status');
        $this->actingAs($admin)->patch(route('web.appointments.status', $appointment), ['status' => 'Confirmed'])
            ->assertRedirect();
        $this->assertSame('Confirmed', $appointment->fresh()->status);

        $this->actingAs($admin)->get('/appointment-details.html?id='.$appointment->id)
            ->assertRedirect(route('web.appointments.show', $appointment));
        $this->actingAs($admin)->get('/appointment-reschedule.html?id='.$appointment->id)
            ->assertRedirect(route('web.appointments.edit', $appointment));
    }

    /** @return array{Company, Patient, Staff} */
    private function context(): array
    {
        $company = Company::create(['code' => 'PHASE2-'.uniqid(), 'name' => 'Phase Two Hospital', 'email' => uniqid().'@phase2.test', 'contact_person' => 'Lead', 'phone' => '+256700220000', 'city' => 'Kampala']);
        $patient = Patient::factory()->create(['company_id' => $company->id, 'first_name' => 'VisiblePatient']);

        return [$company, $patient, $this->doctor($company, 'ST-PHASE2-A-'.uniqid(), 'VisibleDoctor')];
    }

    private function doctor(Company $company, string $code, string $firstName): Staff
    {
        $department = Department::create(['company_id' => $company->id, 'name' => 'Care '.uniqid(), 'status' => 'Active']);

        return Staff::create(['company_id' => $company->id, 'code' => $code, 'first_name' => $firstName, 'last_name' => 'Clinician', 'email' => uniqid().'@doctor.test', 'phone' => '+256700220001', 'role' => 'Doctor', 'specialization' => 'General Medicine', 'department_id' => $department->id, 'status' => 'Active']);
    }

    private function appointment(Company $company, Patient $patient, Staff $doctor, string $time, $date = null): Appointment
    {
        return Appointment::create(['company_id' => $company->id, 'patient_id' => $patient->id, 'doctor_id' => $doctor->id, 'department_id' => $doctor->department_id, 'date' => $date ?? today()->addDay(), 'start_time' => $time, 'end_time' => '09:30', 'duration' => '30 min', 'type' => 'Consultation', 'status' => 'Pending']);
    }
}
