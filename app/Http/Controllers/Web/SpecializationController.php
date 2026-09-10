<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SpecializationController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Specialization::class);
        $specializations = Specialization::forCompany($request->user())->with('department')
            ->when($request->string('search')->trim()->value(), fn ($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->orderBy('name')->paginate(15)->withQueryString();
        $doctorCounts = Staff::forCompany($request->user())->whereNotNull('specialization')->selectRaw('specialization, count(*) as aggregate')->groupBy('specialization')->pluck('aggregate', 'specialization');
        return view('specializations.index', compact('specializations', 'doctorCounts'));
    }

    public function create(Request $request): View { $this->authorize('create', Specialization::class); return view('specializations.create', $this->formData($request)); }
    public function store(Request $request): RedirectResponse { $this->authorize('create', Specialization::class); $specialization = Specialization::create($this->attributes($request)); return redirect()->route('web.specializations.index')->with('status', "{$specialization->name} created successfully."); }
    public function edit(Request $request, Specialization $specialization): View { $this->authorize('update', $specialization); return view('specializations.edit', $this->formData($request) + compact('specialization')); }
    public function update(Request $request, Specialization $specialization): RedirectResponse { $this->authorize('update', $specialization); $oldName = $specialization->name; $data = $this->attributes($request, $specialization); $specialization->update($data); if ($oldName !== $specialization->name) { Staff::forCompany($request->user())->where('specialization', $oldName)->update(['specialization' => $specialization->name]); } return redirect()->route('web.specializations.index')->with('status', 'Specialization updated successfully.'); }
    public function destroy(Request $request, Specialization $specialization): RedirectResponse { $this->authorize('delete', $specialization); abort_if(Staff::forCompany($request->user())->where('specialization', $specialization->name)->exists(), 422, 'Reassign doctors before deactivating this specialization.'); $specialization->update(['status' => 'Inactive']); return back()->with('status', 'Specialization deactivated.'); }

    private function formData(Request $request): array { return ['departments' => Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get()]; }
    private function attributes(Request $request, ?Specialization $specialization = null): array
    {
        $companyId = $specialization?->company_id ?? $request->user()->company_id;
        $data = $request->validate(['name' => ['required', 'string', 'max:100', Rule::unique('specializations')->where('company_id', $companyId)->ignore($specialization?->id)], 'department_id' => ['nullable', 'integer', 'exists:departments,id'], 'description' => ['nullable', 'string', 'max:2000'], 'status' => ['required', Rule::in(['Active', 'Inactive'])]]);
        if (! empty($data['department_id'])) { abort_unless(Department::forCompany($request->user())->whereKey($data['department_id'])->exists(), 403); }
        return $data + ['company_id' => $companyId];
    }
}
