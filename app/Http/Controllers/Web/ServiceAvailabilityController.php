<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceAvailability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceAvailabilityController extends Controller
{
    public function store(Request $request, Service $service): RedirectResponse
    {
        $this->authorize('update', $service);
        $data = $request->validate(['day_of_week' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'], 'slots' => ['required', 'string', 'max:1000']]);
        $service->availability()->updateOrCreate(['day_of_week' => $data['day_of_week']], ['slots' => $data['slots']]);
        return back()->with('status', 'Service availability saved.');
    }

    public function destroy(Service $service, ServiceAvailability $availability): RedirectResponse
    {
        $this->authorize('update', $service);
        abort_unless($availability->service_id === $service->id, 404);
        $availability->delete();
        return back()->with('status', 'Service availability removed.');
    }
}
