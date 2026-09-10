<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $amount = $this->faker->numberBetween(50000, 2000000);

        return [
            'code' => 'INV-' . $this->faker->unique()->numberBetween(10000, 99999),
            'patient_id' => fn () => \App\Models\Patient::factory(),
            'date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
            'amount' => $amount,
            'paid_amount' => 0,
            'balance' => $amount,
            'currency' => 'UGX',
            'status' => 'Pending',
            'insurance_status' => 'Not Submitted',
        ];
    }
}
