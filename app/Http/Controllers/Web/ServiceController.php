<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Service::class);
        $services = Service::forCompany($request->user())->with('department')
            ->when($request->string('search')->trim()->value(), fn ($query, string $search) => $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('type', 'like', "%{$search}%")))
            ->when($request->string('status')->trim()->value(), fn ($query, string $status) => $query->where('status', $status))
            ->orderBy('name')->paginate(15)->withQueryString();

        return view('services.index', compact('services'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Service::class);

        return view('services.create', $this->formData($request));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Service::class);
        $service = Service::create($this->attributes($request));

        return redirect()->route('web.services.show', $service)->with('status', 'Service created successfully.');
    }

    public function show(Service $service): View
    {
        $this->authorize('view', $service);
        $service->load(['department', 'availability']);

        return view('services.show', compact('service'));
    }

    public function edit(Request $request, Service $service): View
    {
        $this->authorize('update', $service);

        return view('services.edit', [...$this->formData($request), 'service' => $service]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $this->authorize('update', $service);
        $service->update($this->attributes($request));

        return redirect()->route('web.services.show', $service)->with('status', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->authorize('delete', $service);
        $service->update(['status' => 'Inactive']);

        return redirect()->route('web.services.index')->with('status', 'Service deactivated.');
    }

    private function formData(Request $request): array
    {
        return ['departments' => Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get(['id', 'name'])];
    }

    private function attributes(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'type' => ['required', Rule::in(['Preventive', 'Diagnostic', 'Treatment', 'Surgical'])],
            'duration' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);
        $department = Department::forCompany($request->user())->findOrFail($data['department_id']);

        return $data + ['department_name' => $department->name, 'currency' => config('app.currency', 'UGX')];
    }
}
