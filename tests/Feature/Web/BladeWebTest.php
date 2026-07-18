<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Tests\TestCase;

class BladeWebTest extends TestCase
{
    public function test_guest_is_redirected_to_the_blade_login_page(): void
    {
        $this->get('/')
            ->assertRedirect(route('login'));

        $this->get('/login')
            ->assertOk()
            ->assertSee('MediTrack HMS')
            ->assertSee('Sign in');
    }

    public function test_admin_can_login_and_view_the_blade_dashboard(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'web-admin@example.com',
            'password' => 'password123',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get('/')
            ->assertOk()
            ->assertSee('Good ')
            ->assertSee($user->name)
            ->assertSee('Upcoming appointments');
    }

    public function test_staff_can_view_blade_patient_and_invoice_lists(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('web.patients.index'))
            ->assertOk()
            ->assertSee('Patients');

        $this->actingAs($user)
            ->get(route('web.invoices.index'))
            ->assertOk()
            ->assertSee('Invoices');
    }

    public function test_patient_is_redirected_from_staff_blade_pages(): void
    {
        $user = User::factory()->patient()->create();

        $this->actingAs($user)
            ->get(route('web.patients.index'))
            ->assertRedirect(route('access.denied'));

        $this->actingAs($user)
            ->get(route('web.invoices.index'))
            ->assertRedirect(route('access.denied'));
    }

    public function test_legacy_screen_is_rendered_by_laravel_as_a_blade_view(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get('/appointments.html')
            ->assertOk()
            ->assertSee('Appointments');
    }
}
