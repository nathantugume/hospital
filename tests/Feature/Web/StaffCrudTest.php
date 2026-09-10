<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class StaffCrudTest extends TestCase
{
    public function test_admin_can_create_update_and_deactivate_staff_with_one_linked_account(): void
    {
        $company = Company::create(['code' => 'STAFF-CRUD', 'name' => 'Staff Hospital', 'email' => 'staff-hospital@example.test', 'contact_person' => 'HR Lead', 'phone' => '+256700330000', 'city' => 'Kampala']);
        $department = Department::create(['company_id' => $company->id, 'name' => 'Nursing', 'status' => 'Active']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);

        $this->actingAs($admin)->get(route('web.staff.create'))->assertOk()->assertSee('Add Staff Member');
        $this->actingAs($admin)->post(route('web.staff.store'), [
            'first_name' => 'Grace', 'last_name' => 'Nurse', 'email' => 'grace.staff@example.test',
            'phone' => '+256700330001', 'role' => 'Nurse', 'position' => 'Senior Nurse',
            'department_id' => $department->id, 'joined_date' => today()->toDateString(), 'status' => 'Active',
            'account_email' => 'grace.login@example.test', 'password' => 'password123',
        ])->assertRedirect();

        $staff = Staff::where('email', 'grace.staff@example.test')->firstOrFail();
        $account = User::where('email', 'grace.login@example.test')->firstOrFail();
        $this->assertSame($staff->id, $account->staff_id);
        $this->assertSame('nurse', $account->role);

        $this->actingAs($admin)->put(route('web.staff.update', $staff), [
            'first_name' => 'Grace', 'last_name' => 'Nurse', 'email' => 'grace.staff@example.test',
            'phone' => '+256700330001', 'role' => 'Nurse', 'position' => 'Ward Lead',
            'department_id' => $department->id, 'joined_date' => today()->toDateString(), 'status' => 'Active',
            'account_email' => 'grace.login@example.test',
        ])->assertRedirect(route('web.staff.show', $staff));
        $this->assertSame(1, User::withTrashed()->where('email', 'grace.login@example.test')->count());
        $this->assertSame('Ward Lead', $staff->fresh()->position);

        $this->actingAs($admin)->delete(route('web.staff.destroy', $staff))->assertRedirect(route('web.staff.index'));
        $this->assertSame('Inactive', $staff->fresh()->status);
        $this->assertTrue($account->fresh()->trashed());
    }
}
