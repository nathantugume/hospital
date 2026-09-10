<?php

namespace Tests\Feature\Billing;

use App\Models\User;
use App\Models\Patient;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $accountant;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountant = User::factory()->create(['role' => 'accountant']);
    }

    public function test_accountant_can_create_invoice(): void
    {
        $patient = Patient::factory()->create();

        $response = $this->actingAs($this->accountant, 'sanctum')
            ->postJson('/api/v1/invoices', [
                'patient_id' => $patient->id,
                'date' => now()->toDateString(),
                'amount' => 500000,
                'currency' => 'UGX',
                'status' => 'Unpaid',
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('invoices', ['patient_id' => $patient->id, 'amount' => 500000]);
    }

    public function test_invoice_validation_rejects_negative_amount(): void
    {
        $patient = Patient::factory()->create();

        $response = $this->actingAs($this->accountant, 'sanctum')
            ->postJson('/api/v1/invoices', [
                'patient_id' => $patient->id,
                'date' => now()->toDateString(),
                'amount' => -100,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['amount']);
    }

    public function test_invoice_requires_valid_patient_id(): void
    {
        $response = $this->actingAs($this->accountant, 'sanctum')
            ->postJson('/api/v1/invoices', [
                'patient_id' => 99999, // non-existent
                'date' => now()->toDateString(),
                'amount' => 100000,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['patient_id']);
    }

    public function test_invoice_can_be_marked_paid(): void
    {
        $invoice = Invoice::factory()->create(['status' => 'Unpaid']);

        $response = $this->actingAs($this->accountant, 'sanctum')
            ->postJson("/api/v1/invoices/{$invoice->id}/pay", [
                'payment_method' => 'MTN MoMo',
                'amount' => $invoice->amount,
            ]);

        $response->assertStatus(200);
        $this->assertEquals('Paid', $invoice->fresh()->status);
    }
}
