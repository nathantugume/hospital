<?php

namespace Tests\Feature\Web;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class DoctorCrudTest extends TestCase
{
    public function test_admin_can_add_a_doctor_with_full_details(): void
    {
        $admin = User::factory()->admin()->create();
        $department = Department::create(['name' => 'Cardiology Department', 'status' => 'Active']);

        $this->actingAs($admin)
            ->get(route('web.doctors.create'))
            ->assertOk()
            ->assertSee('Add Doctor')
            ->assertSee('Professional Details');

        $response = $this->actingAs($admin)->post(route('web.doctors.store'), [
            'first_name' => 'Sarah',
            'last_name' => 'Nakato',
            'date_of_birth' => '1985-03-10',
            'gender' => 'Female',
            'address' => 'Plot 12, Kololo',
            'city' => 'Kampala',
            'state' => 'Central',
            'email' => 'sarah.nakato@meditrack.ea',
            'phone' => '+256700222333',
            'emergency_contact_name' => 'James Nakato',
            'emergency_contact_phone' => '+256700444555',
            'primary_specialization' => 'Cardiology',
            'secondary_specialization' => '',
            'license' => 'LIC-4521',
            'license_expiry' => '2028-01-01',
            'qualifications' => 'MD, FACC',
            'experience' => 8,
            'education' => 'Makerere University Medical School',
            'certifications' => 'Board Certification in Cardiology',
            'department_id' => $department->id,
            'position' => 'Consultant',
            'account_email' => 'sarah.nakato.login@meditrack.ea',
            'password' => 'temporarypass1',
        ]);

        $doctor = Staff::where('first_name', 'Sarah')->where('last_name', 'Nakato')->first();
        $this->assertNotNull($doctor);
        $response->assertRedirect(route('web.doctors.show', $doctor));

        $this->assertSame('Cardiology', $doctor->specialization);
        $this->assertSame('Consultant', $doctor->position);
        $this->assertSame($department->id, $doctor->department_id);
        $this->assertSame('Active', $doctor->status);
        $this->assertNotNull($doctor->code);
        $this->assertStringContainsString('Makerere University', $doctor->education);
        $this->assertStringContainsString('Board Certification in Cardiology', $doctor->education);

        $account = User::where('email', 'sarah.nakato.login@meditrack.ea')->first();
        $this->assertNotNull($account);
        $this->assertSame('doctor', $account->role);
        $this->assertSame($doctor->id, $account->staff_id);

        $this->actingAs($admin)
            ->get(route('web.doctors.show', $doctor))
            ->assertOk()
            ->assertSee('Sarah Nakato')
            ->assertSee('Cardiology');
    }

    public function test_admin_can_edit_and_deactivate_a_doctor(): void
    {
        $admin = User::factory()->admin()->create();
        $department = Department::create(['name' => 'Neurology Department', 'status' => 'Active']);
        $doctor = Staff::create([
            'code' => 'ST-900',
            'first_name' => 'Peter',
            'last_name' => 'Okello',
            'email' => 'peter.okello@meditrack.ea',
            'phone' => '+256700111000',
            'role' => 'Doctor',
            'specialization' => 'Neurology',
            'department_id' => $department->id,
            'position' => 'Senior Resident',
            'status' => 'Active',
            'experience_years' => 4,
        ]);

        $this->actingAs($admin)
            ->get(route('web.doctors.edit', $doctor))
            ->assertOk()
            ->assertSee('Edit Doctor');

        $this->actingAs($admin)
            ->put(route('web.doctors.update', $doctor), [
                'first_name' => 'Peter',
                'last_name' => 'Okello',
                'email' => 'peter.okello@meditrack.ea',
                'phone' => '+256700111000',
                'primary_specialization' => 'Neurology',
                'department_id' => $department->id,
                'position' => 'Chief of Department',
                'experience' => 5,
            ])
            ->assertRedirect(route('web.doctors.show', $doctor));

        $this->assertSame('Chief of Department', $doctor->fresh()->position);
        $this->assertSame('Active', $doctor->fresh()->status);

        $this->actingAs($admin)
            ->delete(route('web.doctors.destroy', $doctor))
            ->assertRedirect(route('web.doctors.index'));

        $this->assertSame('Inactive', $doctor->fresh()->status);
        $this->assertNotSoftDeleted($doctor);
    }

    public function test_non_admin_cannot_manage_doctors(): void
    {
        $nurse = User::factory()->create(['role' => 'nurse']);
        $department = Department::create(['name' => 'Pediatrics Department', 'status' => 'Active']);
        $doctor = Staff::create([
            'code' => 'ST-901',
            'first_name' => 'Grace',
            'last_name' => 'Auma',
            'email' => 'grace.auma@meditrack.ea',
            'phone' => '+256700999111',
            'role' => 'Doctor',
            'specialization' => 'Pediatrics',
            'department_id' => $department->id,
            'position' => 'Consultant',
            'status' => 'Active',
        ]);

        $this->actingAs($nurse)
            ->get(route('web.doctors.create'))
            ->assertRedirect(route('access.denied'));

        $this->actingAs($nurse)
            ->get(route('web.doctors.edit', $doctor))
            ->assertRedirect(route('access.denied'));

        $this->actingAs($nurse)
            ->get(route('web.doctors.show', $doctor))
            ->assertOk();
    }
}
