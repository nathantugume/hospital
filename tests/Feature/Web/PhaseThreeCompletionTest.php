<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\RoleChangeLog;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class PhaseThreeCompletionTest extends TestCase
{
    public function test_hr_manager_records_attendance_timesheet_leave_and_review(): void
    {
        $company = $this->company('PH3-HR');
        $managerStaff = $this->staff($company, 'ST-HRM', 'Manager');
        $manager = User::factory()->create(['company_id' => $company->id, 'staff_id' => $managerStaff->id, 'role' => 'hr_manager']);
        $staff = $this->staff($company, 'ST-HRW', 'Worker');

        $this->actingAs($manager)->post(route('web.staff.attendance.store',$staff), ['date'=>today()->toDateString(),'status'=>'Present','check_in'=>'08:00','check_out'=>'17:00','hours'=>9])->assertRedirect();
        $this->actingAs($manager)->post(route('web.staff.timesheets.store',$staff), ['week_ending'=>today()->toDateString(),'hours'=>40,'overtime_hours'=>2,'status'=>'Approved'])->assertRedirect();
        $this->actingAs($manager)->post(route('web.staff.leave.store',$staff), ['type'=>'Annual','start_date'=>today()->addDay()->toDateString(),'end_date'=>today()->addDays(3)->toDateString(),'status'=>'Approved','reason'=>'Rest'])->assertRedirect();
        $this->actingAs($manager)->post(route('web.staff.reviews.store',$staff), ['period'=>'2026 Q3','review_date'=>today()->toDateString(),'rating'=>4.5,'status'=>'Completed','comments'=>'Strong performance'])->assertRedirect();

        $this->assertDatabaseHas('staff_attendance',['staff_id'=>$staff->id,'status'=>'Present']);
        $this->assertDatabaseHas('staff_timesheets',['staff_id'=>$staff->id,'status'=>'Approved']);
        $this->assertDatabaseHas('staff_leaves',['staff_id'=>$staff->id,'approved_by'=>$managerStaff->id]);
        $this->assertDatabaseHas('staff_reviews',['staff_id'=>$staff->id,'reviewer_id'=>$managerStaff->id]);
    }

    public function test_role_change_is_immediate_audited_and_tenant_safe(): void
    {
        $company = $this->company('PH3-ROLE'); $other = $this->company('PH3-OTHER');
        $admin = User::factory()->admin()->create(['company_id'=>$company->id]);
        $user = User::factory()->create(['company_id'=>$company->id,'role'=>'nurse']);
        $otherUser = User::factory()->create(['company_id'=>$other->id,'role'=>'nurse']);
        $this->actingAs($admin)->patch(route('web.roles.update',$user),['role'=>'lab_technician'])->assertRedirect();
        $this->assertSame('lab_technician',$user->fresh()->role);
        $this->assertTrue(RoleChangeLog::where('user_id',$user->id)->where('prev_role','nurse')->where('new_role','lab_technician')->exists());
        $this->actingAs($admin)->patch(route('web.roles.update',$otherUser),['role'=>'doctor'])->assertForbidden();
    }

    public function test_only_super_admin_manages_companies_and_subscriptions(): void
    {
        $super = User::factory()->create(['role'=>'super_admin','company_id'=>null]);
        $adminCompany = $this->company('PH3-ADMIN');
        $admin = User::factory()->admin()->create(['company_id'=>$adminCompany->id]);
        $this->actingAs($admin)->get(route('web.companies.index'))->assertForbidden();
        $this->actingAs($super)->post(route('web.companies.store'),['code'=>'NEW-HOSP','name'=>'New Hospital','email'=>'new-hospital@example.test','plan'=>'Essential Care','contact_person'=>'Owner','phone'=>'+256700880099','country'=>'Uganda','city'=>'Kampala','beds_count'=>20,'status'=>'Active'])->assertRedirect();
        $company=Company::where('code','NEW-HOSP')->firstOrFail();
        $this->actingAs($super)->post(route('web.companies.subscriptions.store',$company),['plan'=>'Professional Growth','billing_cycle'=>'Annually','amount'=>1200000,'currency'=>'UGX','created_on'=>today()->toDateString(),'expiring_on'=>today()->addYear()->toDateString(),'status'=>'Active'])->assertRedirect();
        $this->assertDatabaseHas('subscriptions',['company_id'=>$company->id,'plan'=>'Professional Growth','status'=>'Active']);
    }

    private function company(string $code): Company { return Company::create(['code'=>$code,'name'=>$code,'email'=>strtolower($code).'@example.test','contact_person'=>'Admin','phone'=>'+256700880000','city'=>'Kampala']); }
    private function staff(Company $company,string $code,string $name): Staff { return Staff::create(['company_id'=>$company->id,'code'=>$code,'first_name'=>$name,'last_name'=>'Staff','email'=>strtolower($code).'@example.test','phone'=>'+256700880001','role'=>'Nurse','status'=>'Active']); }
}
