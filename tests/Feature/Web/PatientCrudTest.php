<?php

namespace Tests\Feature\Web;

use App\Models\Patient;
use App\Models\User;
use Tests\TestCase;

class PatientCrudTest extends TestCase
{
    public function test_receptionist_can_register_a_patient_with_full_details(): void
    {
        $receptionist = User::factory()->create(['role' => 'receptionist']);

        $this->actingAs($receptionist)
            ->get(route('web.patients.create'))
            ->assertOk()
            ->assertSee('Add Patient')
            ->assertSee('Personal Information')
            ->assertSee('Insurance');

        $response = $this->actingAs($receptionist)->post(route('web.patients.store'), [
            'first_name' => 'Grace',
            'middle_name' => 'Nakato',
            'last_name' => 'Amono',
            'date_of_birth' => '1990-04-12',
            'gender' => 'Female',
            'marital_status' => 'Married',
            'address' => 'Plot 9, Ntinda',
            'city' => 'Kampala',
            'district' => 'Kampala',
            'postal_code' => '256',
            'email' => 'grace.amono@example.com',
            'phone' => '+256700111222',
            'preferred_contact' => 'phone',
            'emergency_contact_name' => 'John Amono',
            'emergency_contact_relationship' => 'Spouse',
            'emergency_contact_phone' => '+256700333444',
            'blood_type' => 'O+',
            'height' => '165',
            'weight' => '60',
            'allergies' => 'Penicillin',
            'current_medications' => 'None',
            'chronic_conditions' => 'Asthma',
            'past_surgeries' => 'Appendectomy 2015',
            'previous_hospitalizations' => 'None',
            'family_history_conditions' => ['Diabetes', 'Hypertension'],
            'family_history_notes' => 'Mother has diabetes',
            'smoking_status' => 'Never Smoked',
            'alcohol_consumption' => 'None',
            'insurance_provider' => 'AAR Insurance',
            'insurance_policy_number' => 'POL-99887',
            'insurance_group_number' => 'GRP-1',
            'insurance_policy_holder' => 'Grace Amono',
            'insurance_relationship' => 'Self',
            'insurance_phone' => '+256414100200',
            'consents' => ['Treatment Consent', 'Financial Agreement'],
        ]);

        $patient = Patient::where('first_name', 'Grace')->where('last_name', 'Amono')->first();
        $this->assertNotNull($patient);
        $this->assertSame('grace.amono@example.com', $patient->email);
        $response->assertRedirect(route('web.patients.show', $patient));

        $this->assertSame('Amono', $patient->last_name);
        $this->assertSame('O+', $patient->blood_type);
        $this->assertSame('Asthma', $patient->chronic_conditions);
        $this->assertSame('None', $patient->medical_history);
        $this->assertStringContainsString('Diabetes', $patient->family_history);
        $this->assertStringContainsString('Mother has diabetes', $patient->family_history);
        $this->assertSame('Active', $patient->status);
        $this->assertNotNull($patient->code);

        $this->assertNotNull($patient->primaryInsurance);
        $this->assertSame('AAR Insurance', $patient->primaryInsurance->provider);
        $this->assertSame('POL-99887', $patient->primaryInsurance->policy_number);

        $this->assertSame(2, $patient->consents()->count());
        $this->assertTrue($patient->consents()->where('consent_type', 'Treatment Consent')->exists());

        $this->actingAs($receptionist)
            ->get(route('web.patients.show', $patient))
            ->assertOk()
            ->assertSee('Grace')
            ->assertSee('Amono')
            ->assertSee('AAR Insurance');
    }

    public function test_admin_can_edit_and_delete_a_patient(): void
    {
        $admin = User::factory()->admin()->create();
        $patient = Patient::factory()->create(['first_name' => 'Original', 'last_name' => 'Name']);

        $this->actingAs($admin)
            ->get(route('web.patients.edit', $patient))
            ->assertOk()
            ->assertSee('Edit Patient')
            ->assertSee('Original');

        $this->actingAs($admin)
            ->put(route('web.patients.update', $patient), [
                'first_name' => 'Updated',
                'last_name' => 'Name',
                'date_of_birth' => $patient->date_of_birth->toDateString(),
                'gender' => $patient->gender,
                'phone' => '+256700555666',
            ])
            ->assertRedirect(route('web.patients.show', $patient));

        $this->assertSame('Updated', $patient->fresh()->first_name);

        $this->actingAs($admin)
            ->delete(route('web.patients.destroy', $patient))
            ->assertRedirect(route('web.patients.index'));

        $this->assertSoftDeleted($patient);
    }

    public function test_lab_technician_cannot_register_or_edit_patients(): void
    {
        $labTech = User::factory()->create(['role' => 'lab_technician']);
        $patient = Patient::factory()->create();

        $this->actingAs($labTech)
            ->get(route('web.patients.create'))
            ->assertRedirect(route('access.denied'));

        $this->actingAs($labTech)
            ->get(route('web.patients.edit', $patient))
            ->assertRedirect(route('access.denied'));

        $this->actingAs($labTech)
            ->get(route('web.patients.show', $patient))
            ->assertOk();
    }
}
