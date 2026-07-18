<?php

namespace Tests\Feature\Patients;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $patient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->patient = User::factory()->patient()->create();
    }

    public function test_admin_can_list_patients(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')
            ->getJson('/api/v1/patients');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'data', 'meta' => ['current_page', 'per_page', 'total'],
            ]);
    }

    public function test_admin_can_create_patient(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/patients', [
                'first_name' => 'Okello',
                'last_name' => 'David',
                'date_of_birth' => '1990-01-15',
                'gender' => 'Male',
                'phone' => '+256 712 345 678',
                'email' => 'okello.david@meditrack.com',
                'city' => 'Kampala',
                'country' => 'Uganda',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.first_name', 'Okello');

        $this->assertDatabaseHas('patients', ['first_name' => 'Okello', 'last_name' => 'David']);
    }

    public function test_patient_creation_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/patients', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'date_of_birth', 'gender']);
    }

    public function test_patient_creation_validates_email_format(): void
    {
        $response = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/v1/patients', [
                'first_name' => 'Test',
                'last_name' => 'Patient',
                'date_of_birth' => '1990-01-01',
                'gender' => 'Male',
                'email' => 'not-an-email',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_patient_can_view_own_record(): void
    {
        $patient = Patient::factory()->create(['code' => 'P-TEST-001']);
        $this->patient->update(['patient_id' => $patient->id]);

        $response = $this->actingAs($this->patient, 'sanctum')
            ->getJson("/api/v1/patients/{$patient->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $patient->id);
    }

    public function test_patient_cannot_view_other_patients(): void
    {
        $otherPatient = Patient::factory()->create();

        $response = $this->actingAs($this->patient, 'sanctum')
            ->getJson("/api/v1/patients/{$otherPatient->id}");

        $response->assertStatus(403);
    }

    public function test_admin_can_update_patient(): void
    {
        $patient = Patient::factory()->create();

        $response = $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/v1/patients/{$patient->id}", [
                'first_name' => 'Updated',
                'last_name' => 'Name',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.first_name', 'Updated');
    }

    public function test_admin_can_delete_patient(): void
    {
        $patient = Patient::factory()->create();

        $response = $this->actingAs($this->admin, 'sanctum')
            ->deleteJson("/api/v1/patients/{$patient->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('patients', ['id' => $patient->id]);
    }

    public function test_unauthenticated_request_returns_401(): void
    {
        $response = $this->getJson('/api/v1/patients');
        $response->assertStatus(401);
    }
}
