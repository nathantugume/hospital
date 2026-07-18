<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_present(): void
    {
        $response = $this->getJson('/api/v1/health');

        // HSTS
        $response->assertHeader('Strict-Transport-Security');
        // X-Frame-Options
        $response->assertHeader('X-Frame-Options');
        // X-Content-Type-Options
        $response->assertHeader('X-Content-Type-Options');
        // Referrer-Policy
        $response->assertHeader('Referrer-Policy');
        // Permissions-Policy
        $response->assertHeader('Permissions-Policy');
    }

    public function test_cors_rejects_unknown_origin(): void
    {
        $response = $this->withHeaders([
            'Origin' => 'https://evil.com',
        ])->getJson('/api/v1/health');

        // The response should NOT include the Access-Control-Allow-Origin header
        // for unapproved origins
        $allowOrigin = $response->headers->get('Access-Control-Allow-Origin');
        $this->assertNotEquals('https://evil.com', $allowOrigin);
    }

    public function test_login_is_rate_limited_after_5_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/v1/auth/login', [
                'email' => 'ratelimited@meditrack.com',
                'password' => 'wrong',
            ]);
        }

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'ratelimited@meditrack.com',
            'password' => 'wrong',
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    public function test_api_endpoints_require_authentication(): void
    {
        $endpoints = [
            ['GET', '/api/v1/patients'],
            ['GET', '/api/v1/appointments'],
            ['GET', '/api/v1/invoices'],
            ['GET', '/api/v1/lab-results'],
            ['GET', '/api/v1/medicines'],
            ['GET', '/api/v1/staff'],
            ['GET', '/api/v1/departments'],
        ];

        foreach ($endpoints as [$method, $url]) {
            $response = $this->json($method, $url);
            $this->assertEquals(401, $response->status(), "Endpoint {$url} should require auth");
        }
    }

    public function test_patient_cannot_access_admin_routes(): void
    {
        $patient = User::factory()->create(['role' => 'patient']);

        $response = $this->actingAs($patient, 'sanctum')
            ->getJson('/api/v1/audit-logs');

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_create_companies(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor, 'sanctum')
            ->postJson('/api/v1/companies', [
                'name' => 'Test Hospital',
                'email' => 'test@hospital.com',
                'phone' => '+256 700 000 000',
            ]);

        $response->assertStatus(403);
    }

    public function test_gdpr_data_export_requires_authorization(): void
    {
        $user = User::factory()->create(['role' => 'patient']);
        $patient = \App\Models\Patient::factory()->create();

        // Different patient
        $otherPatient = \App\Models\Patient::factory()->create();
        $user->update(['patient_id' => $patient->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/patients/{$otherPatient->id}/data-export");

        $response->assertStatus(403);
    }
}
