<?php

namespace Tests\Unit;

use App\Services\AfricasTalkingService;
use App\Services\MomoService;
use App\Services\NiraService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_africas_talking_service_can_be_instantiated(): void
    {
        $service = app(AfricasTalkingService::class);
        $this->assertInstanceOf(AfricasTalkingService::class, $service);
    }

    public function test_momo_service_can_be_instantiated(): void
    {
        $service = app(MomoService::class);
        $this->assertInstanceOf(MomoService::class, $service);
    }

    public function test_nira_service_returns_mock_in_sandbox(): void
    {
        $service = app(NiraService::class);
        $verification = $service->verify('CF12345678', 'Uganda');

        $this->assertEquals('verified', $verification->status);
        $this->assertNotNull($verification->full_name);
    }

    public function test_user_role_helpers_work(): void
    {
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isSuperAdmin());

        $superAdmin = \App\Models\User::factory()->create(['role' => 'super_admin']);
        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertTrue($superAdmin->isAdmin()); // super_admin is also admin

        $doctor = \App\Models\User::factory()->create(['role' => 'doctor']);
        $this->assertTrue($doctor->isDoctor());
        $this->assertFalse($doctor->isAdmin());
    }
}
