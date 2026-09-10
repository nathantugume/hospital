<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\Department;
use App\Models\Staff;
use App\Models\StaffAvailability;
use App\Models\Patient;
use App\Models\User;
use Tests\TestCase;

class DoctorAvailabilityTest extends TestCase
{
    public function test_admin_can_manage_a_doctors_recurring_availability(): void
    {
        [$admin, $doctor] = $this->context();

        $this->actingAs($admin)->get(route('web.doctors.availability.index', $doctor))
            ->assertOk()
            ->assertSee('Manage Availability');

        $this->actingAs($admin)->post(route('web.doctors.availability.store', $doctor), [
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'is_available' => true,
            'notes' => 'Monday clinic',
        ])->assertRedirect();

        $slot = StaffAvailability::where('staff_id', $doctor->id)->firstOrFail();
        $this->assertSame(1, $slot->day_of_week);
        $this->assertTrue($slot->is_available);

        $this->actingAs($admin)->delete(route('web.doctors.availability.destroy', [$doctor, $slot]))
            ->assertRedirect();
        $this->assertDatabaseMissing('staff_availability', ['id' => $slot->id]);
    }

    public function test_admin_cannot_manage_another_companys_doctor_availability(): void
    {
        [$admin] = $this->context();
        $otherCompany = Company::create([
            'code' => 'OTHER-AVAIL', 'name' => 'Other Hospital', 'email' => 'other-availability@example.test',
            'contact_person' => 'Other Contact', 'phone' => '+256700110000', 'city' => 'Entebbe',
        ]);
        $otherDoctor = Staff::create([
            'company_id' => $otherCompany->id, 'code' => 'ST-OTHER', 'first_name' => 'Other', 'last_name' => 'Doctor',
            'email' => 'other.doctor@example.test', 'phone' => '+256700110001', 'role' => 'Doctor',
            'specialization' => 'Cardiology', 'status' => 'Active',
        ]);

        $this->actingAs($admin)->get(route('web.doctors.availability.index', $otherDoctor))->assertForbidden();
    }

    public function test_approved_leave_blocks_scheduling_for_the_doctor(): void
    {
        [$admin, $doctor] = $this->context();
        $date = today()->addDays(4);

        $this->actingAs($admin)->post(route('web.doctors.leave.store', $doctor), [
            'type' => 'Annual',
            'start_date' => $date->toDateString(),
            'end_date' => $date->toDateString(),
            'reason' => 'Planned leave',
        ])->assertRedirect();

        $leave = $doctor->leaves()->firstOrFail();
        $this->assertSame('Approved', $leave->status);
        $this->actingAs($admin)->get(route('web.doctors.availability.index', $doctor))
            ->assertOk()->assertSee('Planned leave');

        $patient = Patient::factory()->create(['company_id' => $doctor->company_id]);
        $this->actingAs($admin)->from(route('web.appointments.create'))->post(route('web.appointments.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'department_id' => $doctor->department_id,
            'date' => $date->toDateString(),
            'start_time' => '09:00',
            'duration_minutes' => 30,
            'type' => 'Consultation',
            'status' => 'Pending',
        ])->assertSessionHasErrors('start_time');
    }

    /** @return array{User, Staff} */
    private function context(): array
    {
        $company = Company::create([
            'code' => 'AVAILABILITY', 'name' => 'Availability Hospital', 'email' => 'availability@example.test',
            'contact_person' => 'Availability Lead', 'phone' => '+256700100010', 'city' => 'Kampala',
        ]);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $department = Department::create(['company_id' => $company->id, 'name' => 'Cardiology', 'status' => 'Active']);
        $doctor = Staff::create([
            'company_id' => $company->id, 'code' => 'ST-AVAIL', 'first_name' => 'Sarah', 'last_name' => 'Nakato',
            'email' => 'sarah.availability@example.test', 'phone' => '+256700100011', 'role' => 'Doctor',
            'specialization' => 'Cardiology', 'department_id' => $department->id, 'status' => 'Active',
        ]);

        return [$admin, $doctor];
    }
}
