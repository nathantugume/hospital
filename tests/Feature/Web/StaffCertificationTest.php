<?php

namespace Tests\Feature\Web;

use App\Models\Company;
use App\Models\Staff;
use App\Models\User;
use Tests\TestCase;

class StaffCertificationTest extends TestCase
{
    public function test_admin_can_manage_a_tenant_staff_certification(): void
    {
        $company = Company::create(['code' => 'CERT-A', 'name' => 'Credential Hospital', 'email' => 'cert@example.test', 'contact_person' => 'Admin', 'phone' => '+256700660000', 'city' => 'Kampala']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $staff = Staff::create(['company_id' => $company->id, 'code' => 'ST-CERT', 'first_name' => 'Grace', 'last_name' => 'Nurse', 'email' => 'grace.cert@example.test', 'phone' => '+256700660001', 'role' => 'Nurse', 'status' => 'Active']);

        $this->actingAs($admin)->post(route('web.staff.certifications.store', $staff), [
            'cert_name' => 'Advanced Life Support', 'issuing_body' => 'Uganda Medical Council',
            'issue_date' => now()->subYear()->toDateString(), 'expiry_date' => now()->addYear()->toDateString(), 'status' => 'valid',
        ])->assertRedirect();
        $certification = $staff->certifications()->firstOrFail();
        $this->actingAs($admin)->get(route('web.staff.show', $staff))->assertOk()->assertSee('Advanced Life Support');
        $this->actingAs($admin)->put(route('web.staff.certifications.update', [$staff, $certification]), [
            'cert_name' => 'Advanced Life Support', 'issuing_body' => 'Uganda Medical Council',
            'issue_date' => now()->subYear()->toDateString(), 'expiry_date' => now()->addYear()->toDateString(), 'status' => 'revoked',
        ])->assertRedirect();
        $this->assertSame('revoked', $certification->fresh()->status);
        $this->actingAs($admin)->delete(route('web.staff.certifications.destroy', [$staff, $certification]))->assertRedirect();
        $this->assertDatabaseMissing('staff_certifications', ['id' => $certification->id]);
    }

    public function test_admin_cannot_add_certification_to_another_company_staff(): void
    {
        $company = Company::create(['code' => 'CERT-B', 'name' => 'Hospital B', 'email' => 'certb@example.test', 'contact_person' => 'Admin', 'phone' => '+256700660010', 'city' => 'Kampala']);
        $other = Company::create(['code' => 'CERT-C', 'name' => 'Hospital C', 'email' => 'certc@example.test', 'contact_person' => 'Admin', 'phone' => '+256700660011', 'city' => 'Jinja']);
        $admin = User::factory()->admin()->create(['company_id' => $company->id]);
        $staff = Staff::create(['company_id' => $other->id, 'code' => 'ST-CERT-OTHER', 'first_name' => 'Other', 'last_name' => 'Nurse', 'email' => 'other.cert@example.test', 'phone' => '+256700660012', 'role' => 'Nurse', 'status' => 'Active']);

        $this->actingAs($admin)->post(route('web.staff.certifications.store', $staff), [
            'cert_name' => 'Credential', 'issuing_body' => 'Council', 'issue_date' => now()->toDateString(), 'status' => 'valid',
        ])->assertForbidden();
        $this->assertDatabaseCount('staff_certifications', 0);
    }
}
