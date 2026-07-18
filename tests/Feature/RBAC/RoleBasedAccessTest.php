<?php

namespace Tests\Feature\RBAC;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedAccessTest extends TestCase
{
    public function test_admin_can_list_patients(): void
    {
        $admin = User::factory()->admin()->create();
        $token = $admin->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/v1/patients');

        $response->assertStatus(200);
    }

    public function test_patient_cannot_create_other_patients(): void
    {
        $patientUser = User::factory()->patient()->create();
        $token = $patientUser->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/v1/patients', [
                'first_name' => 'Test',
                'last_name' => 'Patient',
                'date_of_birth' => '1990-01-01',
                'gender' => 'Male',
            ]);

        $response->assertStatus(403);
    }

    public function test_unauthenticated_request_returns_401(): void
    {
        $response = $this->getJson('/api/v1/patients');
        $response->assertStatus(401);
    }

    public function test_health_endpoint_is_public(): void
    {
        $response = $this->getJson('/api/v1/health');
        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'status', 'services' => ['database', 'redis', 'queue']]);
    }

    public function test_invalid_token_returns_401(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer invalid-token-12345')
            ->getJson('/api/v1/patients');

        $response->assertStatus(401);
    }

    public function test_unknown_endpoint_returns_404_with_consistent_format(): void
    {
        $response = $this->getJson('/api/v1/nonexistent-endpoint');
        $response->assertStatus(404)
            ->assertJsonPath('success', false);
    }
}
