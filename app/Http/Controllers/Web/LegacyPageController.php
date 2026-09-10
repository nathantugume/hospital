<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegacyPageController extends Controller
{
    public function show(Request $request, string $page): View|RedirectResponse
    {
        $nativeRoutes = [
            'appointments' => 'web.appointments.index',
            'add-appointment' => 'web.appointments.create',
            'appointment-calendar' => 'web.appointments.calendar',
            'appointment-requests' => 'web.appointment-requests.index',
            'doctor-schedule' => 'web.appointments.calendar',
            'schedule' => 'web.appointments.calendar',
            'departments' => 'web.departments.index',
            'services' => 'web.services.index',
            'wards' => 'web.wards.index',
            'specialisation' => 'web.specializations.index',
            'specializations' => 'web.specializations.index',
            'test-requests' => 'web.laboratory.requests',
            'sample-collection' => 'web.laboratory.requests',
            'result-entry' => 'web.laboratory.results',
            'lab-results' => 'web.laboratory.results',
            'lab-tests-management' => 'web.laboratory.catalogue',
            'lab-equipment' => 'web.laboratory.equipment',
            'lab-result-details' => 'web.laboratory.results',
            'prescriptions' => 'web.prescriptions.index',
            'create-prescription' => 'web.prescriptions.create',
            'medicine' => 'web.pharmacy.index',
            'add-medicine' => 'web.pharmacy.create',
            'stock-alerts' => 'web.pharmacy.alerts',
            'medicine-templates' => 'web.pharmacy.templates',
            'roles-permissions' => 'web.roles.index',
            'role-permission' => 'web.roles.index',
            'companies' => 'web.companies.index',
            'subscriptions' => 'web.companies.index',
            'add-staff' => 'web.staff.create',
            'staff-management' => 'web.staff.index',
            'staff-list' => 'web.staff.index',
            'staff-attendance' => 'web.staff.index',
            'staff-timesheet' => 'web.staff.index',
            'staff-leave' => 'web.staff.index',
            'performance-review' => 'web.staff.index',
        ];

        if (array_key_exists($page, $nativeRoutes)) {
            return redirect()->route($nativeRoutes[$page]);
        }

        if (in_array($page, ['appointment-details', 'appointment-reschedule', 'edit-appointment'], true)) {
            $appointmentId = $request->integer('id');

            if ($appointmentId > 0) {
                $route = $page === 'appointment-details' ? 'web.appointments.show' : 'web.appointments.edit';

                return redirect()->route($route, $appointmentId);
            }

            return redirect()->route('web.appointments.index');
        }

        if (in_array($page, ['medicine-details', 'edit-medicine'], true)) {
            $medicineId = $request->integer('id');
            return $medicineId > 0 ? redirect()->route($page === 'medicine-details' ? 'web.pharmacy.show' : 'web.pharmacy.edit', $medicineId) : redirect()->route('web.pharmacy.index');
        }

        if (in_array($page, ['prescription-details', 'edit-prescription'], true)) {
            $prescriptionId = $request->integer('id');
            return $prescriptionId > 0 ? redirect()->route($page === 'prescription-details' ? 'web.prescriptions.show' : 'web.prescriptions.edit', $prescriptionId) : redirect()->route('web.prescriptions.index');
        }

        abort_unless(view()->exists("legacy.{$page}"), 404);

        return view('coming-soon', [
            'featureTitle' => ucwords(str_replace(['-', '_'], ' ', $page)),
        ]);
    }
}
