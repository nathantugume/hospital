<?php

namespace Tests\Feature\Web;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\StaffAvailability;
use App\Models\User;
use Tests\TestCase;

class AppointmentSchedulingTest extends TestCase
{
    public function test_receptionist_can_schedule_an_appointment_for_its_company(): void
    {
        [$user, $patient, $doctor, $department] = $this->scheduleContext();

        $this->actingAs($user)->get(route('web.appointments.create'))
            ->assertOk()
            ->assertSee('Add Appointment')
            ->assertSee($patient->full_name)
            ->assertSee($doctor->full_name);

        $this->actingAs($user)->get('/add-appointment.html')
            ->assertRedirect(route('web.appointments.create'));

        $this->actingAs($user)->get(route('web.appointments.calendar'))
            ->assertOk()
            ->assertSee('Appointment Calendar');
        $this->actingAs($user)->get('/appointment-calendar.html')
            ->assertRedirect(route('web.appointments.calendar'));

        $response = $this->actingAs($user)->post(route('web.appointments.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'date' => today()->addDay()->toDateString(),
            'start_time' => '09:00',
            'duration_minutes' => 30,
            'type' => 'Consultation',
            'status' => 'Confirmed',
            'notes' => 'Review symptoms',
        ]);

        $appointment = Appointment::where('patient_id', $patient->id)->firstOrFail();
        $response->assertRedirect(route('web.appointments.show', $appointment));
        $this->assertSame($user->company_id, $appointment->company_id);
        $this->assertSame('09:30:00', $appointment->end_time);
        $this->assertSame('30 min', $appointment->duration);
    }

    public function test_overlapping_doctor_appointment_is_rejected(): void
    {
        [$user, $patient, $doctor, $department] = $this->scheduleContext();
        Appointment::create([
            'company_id' => $user->company_id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'date' => today()->addDay(),
            'start_time' => '09:00',
            'end_time' => '09:30',
            'duration' => '30 min',
            'type' => 'Consultation',
            'status' => 'Confirmed',
        ]);

        $this->actingAs($user)->from(route('web.appointments.create'))->post(route('web.appointments.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'date' => today()->addDay()->toDateString(),
            'start_time' => '09:15',
            'duration_minutes' => 30,
            'type' => 'Consultation',
            'status' => 'Pending',
        ])->assertRedirect(route('web.appointments.create'))
            ->assertSessionHasErrors('start_time');
    }

    public function test_appointment_outside_configured_doctor_availability_is_rejected(): void
    {
        [$user, $patient, $doctor, $department] = $this->scheduleContext();
        $date = today()->addDay();
        StaffAvailability::create([
            'staff_id' => $doctor->id,
            'date' => $date,
            'start_time' => '09:00',
            'end_time' => '10:00',
        ]);

        $this->actingAs($user)->from(route('web.appointments.create'))->post(route('web.appointments.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'date' => $date->toDateString(),
            'start_time' => '10:00',
            'duration_minutes' => 30,
            'type' => 'Consultation',
            'status' => 'Pending',
        ])->assertRedirect(route('web.appointments.create'))
            ->assertSessionHasErrors('start_time');
    }

    public function test_legacy_appointment_without_end_time_still_blocks_an_overlap(): void
    {
        [$user, $patient, $doctor, $department] = $this->scheduleContext();
        Appointment::create([
            'company_id' => $user->company_id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'date' => today()->addDay(),
            'start_time' => '09:00',
            'end_time' => null,
            'duration' => '30 min',
            'type' => 'Consultation',
            'status' => 'Confirmed',
        ]);

        $this->actingAs($user)->from(route('web.appointments.create'))->post(route('web.appointments.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'date' => today()->addDay()->toDateString(),
            'start_time' => '09:15',
            'duration_minutes' => 30,
            'type' => 'Consultation',
            'status' => 'Pending',
        ])->assertSessionHasErrors('start_time');
    }

    public function test_date_specific_blocked_slot_overrides_recurring_availability(): void
    {
        [$user, $patient, $doctor, $department] = $this->scheduleContext();
        $date = today()->next(\Carbon\Carbon::MONDAY);
        StaffAvailability::create(['staff_id' => $doctor->id, 'day_of_week' => \Carbon\Carbon::MONDAY, 'start_time' => '08:00', 'end_time' => '17:00', 'is_available' => true]);
        StaffAvailability::create(['staff_id' => $doctor->id, 'date' => $date, 'start_time' => '09:00', 'end_time' => '12:00', 'is_available' => false]);

        $this->actingAs($user)->from(route('web.appointments.create'))->post(route('web.appointments.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $department->id,
            'date' => $date->toDateString(),
            'start_time' => '10:00',
            'duration_minutes' => 30,
            'type' => 'Consultation',
            'status' => 'Pending',
        ])->assertSessionHasErrors('start_time');
    }

    /** @return array{User, Patient, Staff, Department} */
    private function scheduleContext(): array
    {
        $company = Company::create([
            'code' => 'APPOINTMENTS',
            'name' => 'Appointments Hospital',
            'email' => 'appointments@example.test',
            'contact_person' => 'Reception Lead',
            'phone' => '+256700100000',
            'city' => 'Kampala',
        ]);
        $user = User::factory()->create(['role' => 'receptionist', 'company_id' => $company->id]);
        $department = Department::create(['company_id' => $company->id, 'name' => 'General Care', 'status' => 'Active']);
        $patient = Patient::factory()->create(['company_id' => $company->id]);
        $doctor = Staff::create([
            'company_id' => $company->id,
            'code' => 'ST-APP',
            'first_name' => 'Sarah',
            'last_name' => 'Nakato',
            'email' => 'sarah.appointments@example.test',
            'phone' => '+256700100001',
            'role' => 'Doctor',
            'specialization' => 'Cardiology',
            'department_id' => $department->id,
            'status' => 'Active',
        ]);

        return [$user, $patient, $doctor, $department];
    }
}
