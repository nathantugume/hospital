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

    public function test_invalid_browser_credentials_return_to_login_with_errors(): void
    {
        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'missing@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout_from_the_browser_session(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_registration_creates_a_patient_account_and_logs_in(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create your account');

        $this->post(route('register.store'), [
            'name' => 'New Demo Patient',
            'email' => 'new-patient@example.com',
            'phone' => '+256700000000',
            'password' => 'StrongPassword123!',
            'password_confirmation' => 'StrongPassword123!',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'new-patient@example.com',
            'role' => 'patient',
        ]);
    }

    public function test_password_reset_views_are_available(): void
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Forgot your password?');

        $this->get(route('password.reset', ['token' => 'demo-token', 'email' => 'patient@example.com']))
            ->assertOk()
            ->assertSee('Choose a new password');
    }

    public function test_two_factor_user_is_sent_to_the_browser_challenge(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'two-factor@example.com',
            'password' => 'password123',
            'two_factor_secret' => encrypt('JBSWY3DPEHPK3PXP'),
            'two_factor_confirmed_at' => now(),
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('two-factor.login'));

        $this->assertGuest();
        $this->get(route('two-factor.login'))
            ->assertOk()
            ->assertSee('Verify your identity');
    }
}
