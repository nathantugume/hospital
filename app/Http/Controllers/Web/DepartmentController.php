<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Department::class);
        $departments = Department::forCompany($request->user())->with(['head', 'staff', 'services'])
            ->when($request->string('search')->trim()->value(), fn ($query, string $search) => $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%")))
            ->when($request->string('status')->trim()->value(), fn ($query, string $status) => $query->where('status', $status))
            ->orderBy('name')->paginate(15)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Department::class);

        return view('departments.create', $this->formData($request));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Department::class);
        $department = Department::create($this->attributes($request));

        return redirect()->route('web.departments.show', $department)->with('status', 'Department created successfully.');
    }

    public function show(Department $department): View
    {
        $this->authorize('view', $department);
        $department->load(['head', 'staff', 'services']);

        return view('departments.show', compact('department'));
    }

    public function edit(Request $request, Department $department): View
    {
        $this->authorize('update', $department);

        return view('departments.edit', [...$this->formData($request), 'department' => $department]);
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $this->authorize('update', $department);
        $department->update($this->attributes($request, $department));

        return redirect()->route('web.departments.show', $department)->with('status', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $this->authorize('delete', $department);
        $department->update(['status' => 'Inactive']);

        return redirect()->route('web.departments.index')->with('status', 'Department deactivated.');
    }

    private function formData(Request $request): array
    {
        return ['staff' => Staff::forCompany($request->user())->where('status', 'Active')->orderBy('first_name')->get(['id', 'first_name', 'last_name'])];
    }

    private function attributes(Request $request, ?Department $department = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['nullable', 'string', 'max:20', Rule::unique('departments', 'code')->ignore($department?->id)],
            'head_staff_id' => ['nullable', 'integer', 'exists:staff,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);
        $companyId = $department?->company_id ?? $request->user()->company_id;
        if (! empty($data['head_staff_id'])) {
            abort_unless(Staff::query()->where('company_id', $companyId)->whereKey($data['head_staff_id'])->exists(), 422);
        }

        return $data + ['company_id' => $companyId];
    }
}
