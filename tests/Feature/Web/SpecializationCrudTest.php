<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class SpecializationCrudTest extends TestCase
{
    public function test_admin_manages_specializations_and_renames_linked_doctors(): void
    {
        $company = Company::create(['code' => 'SPEC-A', 'name' => 'Specialist Hospital', 'email' => 'spec@example.test', 'contact_person' => 'Admin', 'phone' => '+256700550000', 'city' => 'Kampala']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $department = Department::create(['company_id' => $company->id, 'name' => 'Heart Centre', 'code' => 'HEART', 'status' => 'Active']);

        $this->actingAs($admin)->post(route('web.specializations.store'), ['name' => 'Cardiology', 'department_id' => $department->id, 'description' => 'Heart care', 'status' => 'Active'])->assertRedirect(route('web.specializations.index'));
        $specialization = Specialization::where('company_id', $company->id)->where('name', 'Cardiology')->firstOrFail();
        $doctor = Staff::create(['company_id' => $company->id, 'code' => 'ST-SPEC', 'first_name' => 'Joan', 'last_name' => 'Doctor', 'email' => 'joan.spec@example.test', 'phone' => '+256700550001', 'role' => 'Doctor', 'specialization' => 'Cardiology', 'status' => 'Active']);

        $this->actingAs($admin)->put(route('web.specializations.update', $specialization), ['name' => 'Cardiovascular Medicine', 'department_id' => $department->id, 'description' => 'Heart care', 'status' => 'Active'])->assertRedirect(route('web.specializations.index'));
        $this->assertSame('Cardiovascular Medicine', $doctor->fresh()->specialization);
        $this->actingAs($admin)->delete(route('web.specializations.destroy', $specialization))->assertStatus(422);
        $this->actingAs($admin)->get('/specialisation.html')->assertRedirect(route('web.specializations.index'));
    }

    public function test_admin_cannot_use_another_company_department(): void
    {
        $company = Company::create(['code' => 'SPEC-B', 'name' => 'Hospital B', 'email' => 'specb@example.test', 'contact_person' => 'Admin', 'phone' => '+256700550010', 'city' => 'Kampala']);
        $other = Company::create(['code' => 'SPEC-C', 'name' => 'Hospital C', 'email' => 'specc@example.test', 'contact_person' => 'Admin', 'phone' => '+256700550011', 'city' => 'Jinja']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $department = Department::create(['company_id' => $other->id, 'name' => 'Other Department', 'code' => 'OTHER-SPEC', 'status' => 'Active']);

        $this->actingAs($admin)->post(route('web.specializations.store'), ['name' => 'Neurology', 'department_id' => $department->id, 'status' => 'Active'])->assertForbidden();
        $this->assertDatabaseMissing('specializations', ['company_id' => $company->id, 'name' => 'Neurology']);
    }
}
