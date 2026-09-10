<?php

namespace Tests\Feature\Web;

use App\Models\Invoice;
use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use Tests\TestCase;

class ReferenceUiTest extends TestCase
{
    public function test_dashboard_chart_uses_paid_invoices_and_does_not_expose_another_users_notifications(): void
    {
        $admin = User::factory()->admin()->create(['company_id' => Company::query()->firstOrFail()->id]);
        $other = User::factory()->create();
        Notification::forceCreate(['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $admin->id, 'type' => 'info', 'title' => 'My clinical alert', 'message' => 'Visible to this user', 'category' => 'appointments']);
        Notification::forceCreate(['id' => (string) \Illuminate\Support\Str::uuid(), 'user_id' => $other->id, 'type' => 'info', 'title' => 'Private other-user alert', 'message' => 'Must not leak', 'category' => 'appointments']);
        $month = now()->startOfMonth()->subMonths(5);
        $expected = (float) Invoice::forCompany($admin)->where('status', 'Paid')->whereBetween('payment_date', [$month, $month->copy()->endOfMonth()])->sum('paid_amount');
        Invoice::factory()->create(['company_id' => $admin->company_id, 'status' => 'Paid', 'payment_date' => $month, 'paid_amount' => 12345]);
        Invoice::factory()->create(['company_id' => $admin->company_id, 'status' => 'Pending', 'payment_date' => $month, 'paid_amount' => 999999]);

        $this->actingAs($admin)->get('/')
            ->assertOk()
            ->assertSee('My clinical alert')
            ->assertDontSee('Private other-user alert')
            ->assertDontSee('js/meditrack-store.js')
            ->assertDontSee('js/meditrack.js')
            ->assertViewHas('chart', fn ($chart) => $chart->count() === 6 && $chart->first()['revenue'] === $expected + 12345);
    }

    public function test_role_navigation_does_not_include_admin_reference_menu_for_patient(): void
    {
        $patient = User::factory()->create(['role' => 'patient']);
        $this->actingAs($patient)->get('/')
            ->assertOk()
            ->assertSee('My care')
            ->assertSee('No upcoming appointments have been recorded.')
            ->assertViewHas('stats', fn ($stats) => $stats['appointments'] === 0 && $stats['outstanding'] === 0)
            ->assertDontSee('class="doctors-toggle', false)
            ->assertDontSee(route('admin.settings.edit'));
        $this->actingAs($patient)->get(route('admin.settings.edit'))->assertRedirect(route('access.denied'));
    }

    public function test_reference_login_retains_native_form_fields_and_escaped_validation(): void
    {
        $response = $this->get('/login')->assertOk();
        $document = new \DOMDocument();
        @$document->loadHTML($response->getContent());
        $xpath = new \DOMXPath($document);
        $this->assertSame(1, $xpath->query('//form[@method="POST"]//input[@name="_token"]')->length);
        $this->assertSame(1, $xpath->query('//form//input[@name="password" and @type="password"]')->length);
        $this->assertSame(1, $xpath->query('//form//button[@type="submit"]')->length);
        $this->assertSame(1, $xpath->query('//button[@id="togglePassword"]')->length);
        $response->assertDontSee('value="password123"', false)->assertDontSee('DEMO_USERS');
    }

    public function test_dashboard_date_filter_includes_boundary_payments_and_excludes_other_periods(): void
    {
        $admin = User::factory()->admin()->create(['company_id' => Company::query()->firstOrFail()->id]);
        foreach (['2025-01-14' => 9000, '2025-01-15' => 1000, '2025-01-20' => 2000, '2025-01-21' => 8000] as $date => $amount) {
            Invoice::factory()->create(['company_id' => $admin->company_id, 'status' => 'Paid', 'payment_date' => $date, 'paid_amount' => $amount, 'payment_method' => 'Cash']);
        }
        Invoice::factory()->create(['company_id' => $admin->company_id, 'status' => 'Pending', 'payment_date' => '2025-01-16', 'paid_amount' => 5000]);

        $this->actingAs($admin)->get('/?from=2025-01-15&to=2025-01-20')
            ->assertOk()
            ->assertSee('Patient Demographics')
            ->assertSee('Staff Performance')
            ->assertViewHas('chart', fn ($chart) => $chart->count() === 1 && $chart->first()['revenue'] === 3000.0)
            ->assertViewHas('analytics', fn ($analytics) => $analytics['periodRevenue'] === 3000.0 && $analytics['revenueSources']->first()['value'] === 3000.0);

        $this->actingAs($admin)->getJson('/?from=invalid&to=2025-01-20')
            ->assertUnprocessable()->assertJsonValidationErrors('from');
        $this->actingAs($admin)->getJson('/?from=2025-01-20&to=2025-01-15')
            ->assertUnprocessable()->assertJsonValidationErrors('to');
        $this->actingAs($admin)->getJson('/?from=2020-01-01&to=2025-01-20')
            ->assertUnprocessable()->assertJsonValidationErrors('to');
    }
}
