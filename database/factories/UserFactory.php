<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '+256 7' . rand(10, 89) . ' ' . rand(100, 999) . ' ' . rand(100, 999),
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'preferred_currency' => 'UGX',
            'timezone' => 'Africa/Kampala',
        ];
    }

    public function admin(): static
    {
        return $this->state(fn() => ['role' => 'admin']);
    }

    public function doctor(): static
    {
        return $this->state(fn() => ['role' => 'doctor']);
    }

    public function patient(): static
    {
        return $this->state(fn() => ['role' => 'patient']);
    }

    public function unverified(): static
    {
        return $this->state(fn() => ['email_verified_at' => null]);
    }
}
