<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\Department;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class DepartmentServiceCrudTest extends TestCase
{
    public function test_admin_can_manage_tenant_departments_and_services(): void
    {
        $company = Company::create(['code' => 'DEPT-SVC', 'name' => 'Department Hospital', 'email' => 'department@example.test', 'contact_person' => 'Admin', 'phone' => '+256700440000', 'city' => 'Kampala']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $head = Staff::create(['company_id' => $company->id, 'code' => 'ST-DEPT-SVC', 'first_name' => 'Moses', 'last_name' => 'Head', 'email' => 'moses.head@example.test', 'phone' => '+256700440001', 'role' => 'Nurse', 'status' => 'Active']);

        $this->actingAs($admin)->post(route('web.departments.store'), [
            'name' => 'Outpatient Care', 'code' => 'OPD-NEW', 'head_staff_id' => $head->id,
            'description' => 'Walk-in clinical care', 'status' => 'Active',
        ])->assertRedirect();
        $department = Department::where('code', 'OPD-NEW')->firstOrFail();
        $this->assertSame($company->id, $department->company_id);

        $this->actingAs($admin)->post(route('web.services.store'), [
            'name' => 'General Consultation', 'department_id' => $department->id, 'type' => 'Preventive',
            'duration' => '30 min', 'price' => 50000, 'status' => 'Active',
        ])->assertRedirect();
        $service = Service::where('name', 'General Consultation')->firstOrFail();
        $this->assertSame($department->id, $service->department_id);

        $this->actingAs($admin)->get('/departments.html')->assertRedirect(route('web.departments.index'));
        $this->actingAs($admin)->get('/services.html')->assertRedirect(route('web.services.index'));
        $this->actingAs($admin)->get(route('web.services.show', $service))->assertOk()->assertSee('General Consultation');
    }

    public function test_admin_cannot_assign_a_department_head_from_another_company(): void
    {
        $company = Company::create(['code' => 'DEPT-A', 'name' => 'Department A', 'email' => 'depta@example.test', 'contact_person' => 'Admin', 'phone' => '+256700440010', 'city' => 'Kampala']);
        $other = Company::create(['code' => 'DEPT-B', 'name' => 'Department B', 'email' => 'deptb@example.test', 'contact_person' => 'Admin', 'phone' => '+256700440011', 'city' => 'Entebbe']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $otherHead = Staff::create(['company_id' => $other->id, 'code' => 'ST-DEPT-OTHER', 'first_name' => 'Other', 'last_name' => 'Head', 'email' => 'other.head@example.test', 'phone' => '+256700440012', 'role' => 'Nurse', 'status' => 'Active']);

        $this->actingAs($admin)->post(route('web.departments.store'), [
            'name' => 'Invalid Department', 'code' => 'INVALID', 'head_staff_id' => $otherHead->id, 'status' => 'Active',
        ])->assertStatus(422);
    }
}
