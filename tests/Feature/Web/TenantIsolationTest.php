<?php

namespace Tests\Feature\Web;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    public function test_staff_only_see_patients_and_appointments_from_their_company(): void
    {
        [$companyA, $companyB] = $this->companies();
        $admin = User::factory()->admin()->create(['company_id' => $companyA->id]);
        $patientA = Patient::factory()->create(['company_id' => $companyA->id, 'first_name' => 'Amina']);
        $patientB = Patient::factory()->create(['company_id' => $companyB->id, 'first_name' => 'Beatrice']);

        Appointment::create([
            'company_id' => $companyA->id,
            'patient_id' => $patientA->id,
            'date' => today(),
            'start_time' => '09:00',
            'type' => 'Consultation',
            'status' => 'Pending',
        ]);
        Appointment::create([
            'company_id' => $companyB->id,
            'patient_id' => $patientB->id,
            'date' => today(),
            'start_time' => '10:00',
            'type' => 'Consultation',
            'status' => 'Pending',
        ]);

        $this->actingAs($admin)
            ->get(route('web.patients.index'))
            ->assertOk()
            ->assertSee('Amina')
            ->assertDontSee('Beatrice');

        $this->actingAs($admin)
            ->get(route('web.appointments.index'))
            ->assertOk()
            ->assertSee('Amina')
            ->assertDontSee('Beatrice');

        $this->actingAs($admin)
            ->get(route('web.patients.show', $patientB))
            ->assertForbidden();
    }

    public function test_doctor_management_cannot_cross_company_boundaries(): void
    {
        [$companyA, $companyB] = $this->companies();
        $admin = User::factory()->admin()->create(['company_id' => $companyA->id]);
        $departmentA = Department::create(['company_id' => $companyA->id, 'name' => 'Cardiology', 'status' => 'Active']);
        $departmentB = Department::create(['company_id' => $companyB->id, 'name' => 'Neurology', 'status' => 'Active']);
        $doctorA = Staff::create([
            'company_id' => $companyA->id,
            'code' => 'ST-A01',
            'first_name' => 'Amos',
            'last_name' => 'Kato',
            'email' => 'amos@example.test',
            'phone' => '+256700000001',
            'role' => 'Doctor',
            'specialization' => 'Cardiology',
            'department_id' => $departmentA->id,
            'status' => 'Active',
        ]);
        $doctorB = Staff::create([
            'company_id' => $companyB->id,
            'code' => 'ST-B01',
            'first_name' => 'Brenda',
            'last_name' => 'Naki',
            'email' => 'brenda@example.test',
            'phone' => '+256700000002',
            'role' => 'Doctor',
            'specialization' => 'Neurology',
            'department_id' => $departmentB->id,
            'status' => 'Active',
        ]);

        $this->actingAs($admin)
            ->get(route('web.doctors.index'))
            ->assertOk()
            ->assertSee('Amos')
            ->assertDontSee('Brenda');

        $this->actingAs($admin)
            ->get(route('web.doctors.show', $doctorB))
            ->assertForbidden();

        $this->actingAs($admin)
            ->get(route('web.doctors.show', $doctorA))
            ->assertOk();
    }

    /** @return array{Company, Company} */
    private function companies(): array
    {
        $companyA = Company::create([
            'code' => 'HOSP-A',
            'name' => 'Hospital A',
            'email' => 'a@example.test',
            'contact_person' => 'A Contact',
            'phone' => '+256700000010',
            'city' => 'Kampala',
        ]);
        $companyB = Company::create([
            'code' => 'HOSP-B',
            'name' => 'Hospital B',
            'email' => 'b@example.test',
            'contact_person' => 'B Contact',
            'phone' => '+256700000011',
            'city' => 'Entebbe',
        ]);

        return [$companyA, $companyB];
    }
}
