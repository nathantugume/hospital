<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Ward;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WardController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Ward::class);
        $wards = Ward::query()->whereHas('department', fn ($q) => $q->forCompany($request->user()))
            ->with('department')->when($request->string('search')->trim()->value(), fn ($q, $s) => $q->where(fn ($q) => $q->where('name', 'like', "%{$s}%")->orWhere('code', 'like', "%{$s}%")))
            ->orderBy('name')->paginate(15)->withQueryString();
        return view('wards.index', compact('wards'));
    }

    public function create(Request $request): View { $this->authorize('create', Ward::class); return view('wards.create', ['departments' => Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get()]); }
    public function store(Request $request): RedirectResponse { $this->authorize('create', Ward::class); $ward = Ward::create($this->attributes($request)); return redirect()->route('web.wards.show', $ward)->with('status', 'Ward created successfully.'); }
    public function show(Ward $ward): View { $this->authorize('view', $ward); $ward->load(['department', 'rooms', 'staff']); return view('wards.show', compact('ward')); }
    public function edit(Request $request, Ward $ward): View { $this->authorize('update', $ward); return view('wards.edit', ['ward' => $ward, 'departments' => Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get()]); }
    public function update(Request $request, Ward $ward): RedirectResponse { $this->authorize('update', $ward); $ward->update($this->attributes($request)); return redirect()->route('web.wards.show', $ward)->with('status', 'Ward updated successfully.'); }
    public function destroy(Ward $ward): RedirectResponse { $this->authorize('delete', $ward); $ward->delete(); return redirect()->route('web.wards.index')->with('status', 'Ward deleted.'); }
    private function attributes(Request $request): array { $data = $request->validate(['department_id' => ['required', 'integer', 'exists:departments,id'], 'name' => ['required', 'string', 'max:100'], 'code' => ['nullable', 'string', 'max:20']]); abort_unless(Department::forCompany($request->user())->whereKey($data['department_id'])->exists(), 403); return $data; }
}
