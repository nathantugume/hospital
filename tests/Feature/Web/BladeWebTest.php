<?php

namespace Tests\Feature\Web;

use App\Models\Invoice;
use App\Models\Patient;
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
            ->assertSee('Sign in')
            ->assertSee('Demo access')
            ->assertSee('admin@meditrack.ea')
            ->assertSee('password123');
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
            ->assertSee('Welcome back')
            ->assertSee('Active patients')
            ->assertSee('data-sidebar', false);

        $this->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Welcome back')
            ->assertSee('Upcoming appointments')
            ->assertSee('Recent invoices');
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

    public function test_admin_can_view_native_operational_pages(): void
    {
        $user = User::factory()->admin()->create();

        $pages = [
            [route('web.appointments.index'), 'Appointments'],
            [route('web.staff.index'), 'Care team'],
            [route('web.laboratory.index'), 'Laboratory'],
            [route('web.pharmacy.index'), 'Pharmacy'],
        ];

        foreach ($pages as [$url, $heading]) {
            $response = $this->actingAs($user)->get($url)->assertOk()->assertSee($heading);

            $this->assertSame(1, substr_count($response->getContent(), '<aside class="app-sidebar"'));
        }
    }

    public function test_admin_can_view_financial_reports_with_real_invoice_data(): void
    {
        $admin = User::factory()->admin()->create();
        $patient = Patient::factory()->create(['first_name' => 'Reporting', 'last_name' => 'Testcase']);
        Invoice::factory()->create([
            'patient_id' => $patient->id,
            'code' => 'INV-REPORT-1',
            'date' => now()->toDateString(),
            'amount' => 40000,
            'paid_amount' => 40000,
            'balance' => 0,
            'status' => 'Paid',
        ]);

        $this->actingAs($admin)
            ->get(route('web.reports.financial', ['from' => now()->toDateString(), 'to' => now()->toDateString()]))
            ->assertOk()
            ->assertSee('Financial Reports')
            ->assertSee('Reporting')
            ->assertSee('Testcase')
            ->assertSee('Total invoiced')
            ->assertSee(now()->format('M Y'));

        $doctor = User::factory()->doctor()->create();

        $this->actingAs($doctor)
            ->get(route('web.reports.financial'))
            ->assertRedirect(route('access.denied'));
    }

    public function test_admin_can_change_currency_from_settings_and_dashboard_uses_it(): void
    {
        $user = User::factory()->admin()->create();
        $patient = Patient::factory()->create();
        Invoice::factory()->create([
            'patient_id' => $patient->id,
            'amount' => 125000,
            'balance' => 125000,
        ]);

        $this->actingAs($user)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('Base Currency')
            ->assertSee('UGX - Ugandan Shilling');

        $this->actingAs($user)
            ->put(route('admin.settings.update'), ['currency' => 'USD'])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHas('status', 'Currency settings updated successfully.');

        $this->assertDatabaseHas('settings', ['key' => 'default_currency', 'value' => 'USD']);

        $this->actingAs($user)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertSee('Preview:')
            ->assertSee('$ 125,000.00');

        $expectedOutstanding = app(\App\Services\CurrencyService::class)->format(
            Invoice::whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance')
        );

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($expectedOutstanding)
            ->assertSee('Outstanding balance');
    }

    public function test_patient_cannot_change_system_currency(): void
    {
        $user = User::factory()->patient()->create();

        $this->actingAs($user)
            ->get(route('admin.settings.edit'))
            ->assertRedirect(route('access.denied'));

        $this->actingAs($user)
            ->put(route('admin.settings.update'), ['currency' => 'USD'])
            ->assertRedirect(route('access.denied'));
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

    public function test_legacy_html_pages_show_a_coming_soon_placeholder(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)
            ->get('/appointment-calendar.html')
            ->assertOk()
            ->assertSee('Appointment Calendar is coming soon')
            ->assertSee('data-menu-toggle');

        $this->assertSame(1, substr_count($response->getContent(), '<!doctype html>'));
        $this->assertSame(1, substr_count($response->getContent(), '<aside class="app-sidebar"'));

        $this->actingAs($user)
            ->get('/financial-reports.html')
            ->assertOk()
            ->assertSee('Financial Reports is coming soon')
            ->assertDontSee('apexcharts');

        $this->actingAs($user)
            ->get('/not-a-real-legacy-page.html')
            ->assertNotFound();
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
