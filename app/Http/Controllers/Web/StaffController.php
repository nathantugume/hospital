<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StaffController extends Controller
{
    public const ROLES = [
        'Nurse', 'Receptionist', 'Lab Technician', 'Pharmacist', 'Accountant',
        'Insurance Officer', 'HR Manager', 'Inventory Manager', 'Radiology Technician',
        'Physiotherapist', 'Surgeon', 'Blood Bank Staff', 'Ambulance Dispatcher', 'Ambulance Driver',
    ];

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Staff::class);

        $staff = Staff::query()
            ->forCompany($request->user())
            ->with('department')
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('specialization', 'like', "%{$search}%");
                });
            })
            ->when($request->string('status')->trim()->value(), fn ($query, string $status) => $query->where('status', $status))
            ->when($request->integer('department_id'), fn ($query, int $departmentId) => $query->where('department_id', $departmentId))
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'active' => Staff::forCompany($request->user())->where('status', 'Active')->count(),
            'doctors' => Staff::forCompany($request->user())->where('status', 'Active')->whereIn('role', ['Doctor', 'doctor'])->count(),
            'departments' => Department::forCompany($request->user())->where('status', 'Active')->count(),
            'on_leave' => Staff::forCompany($request->user())->where('status', 'On Leave')->count(),
        ];
        $departments = Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get(['id', 'name']);

        return view('staff.index', compact('staff', 'stats', 'departments'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Staff::class);

        return view('staff.create', $this->formData($request));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Staff::class);
        $validated = $this->validated($request);

        $staff = DB::transaction(function () use ($request, $validated): Staff {
            $staff = Staff::create([
                ...$this->staffAttributes($validated),
                'company_id' => $request->user()->company_id,
                'code' => $this->nextStaffCode(),
            ]);
            $this->syncAccount($staff, $validated);

            return $staff;
        });

        return redirect()->route('web.staff.show', $staff)->with('status', 'Staff member added successfully.');
    }

    public function show(Staff $staff): View
    {
        $this->authorize('view', $staff);
        $staff->load(['department', 'user', 'certifications']);

        return view('staff.show', compact('staff'));
    }

    public function edit(Request $request, Staff $staff): View
    {
        $this->authorize('update', $staff);

        return view('staff.edit', [
            ...$this->formData($request),
            'staff' => $staff,
            'account' => $staff->user()->withTrashed()->first(),
        ]);
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $this->authorize('update', $staff);
        $validated = $this->validated($request, $staff);

        DB::transaction(function () use ($staff, $validated): void {
            $staff->update($this->staffAttributes($validated));
            $this->syncAccount($staff, $validated);
            $account = $staff->user()->withTrashed()->first();
            if ($account) {
                if ($staff->status === 'Inactive' && ! $account->trashed()) {
                    $account->delete();
                } elseif ($staff->status === 'Active' && $account->trashed()) {
                    $account->restore();
                }
            }
        });

        return redirect()->route('web.staff.show', $staff)->with('status', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff): RedirectResponse
    {
        $this->authorize('delete', $staff);

        DB::transaction(function () use ($staff): void {
            $staff->update(['status' => 'Inactive']);
            $staff->user()->each(fn (User $user) => $user->delete());
        });

        return redirect()->route('web.staff.index')->with('status', 'Staff member and linked login access deactivated.');
    }

    private function formData(Request $request): array
    {
        return [
            'departments' => Department::forCompany($request->user())->where('status', 'Active')->orderBy('name')->get(['id', 'name']),
            'roles' => self::ROLES,
        ];
    }

    private function validated(Request $request, ?Staff $staff = null): array
    {
        $companyId = $request->user()->company_id;
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('staff', 'email')->ignore($staff?->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in(self::ROLES)],
            'position' => ['nullable', 'string', 'max:100'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'joined_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['Active', 'Inactive', 'On Leave'])],
            'account_email' => ['nullable', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (! empty($validated['department_id'])) {
            abort_unless(Department::query()->where('company_id', $companyId)->whereKey($validated['department_id'])->exists(), 422);
        }

        if (! empty($validated['account_email'])) {
            $existing = User::withTrashed()->where('email', $validated['account_email'])->first();
            if ($existing && $existing->staff_id !== null && $existing->staff_id !== $staff?->id) {
                throw ValidationException::withMessages(['account_email' => 'This login is already linked to another staff record.']);
            }
            if ($existing && ! $request->user()->isSuperAdmin() && $existing->company_id !== $companyId) {
                throw ValidationException::withMessages(['account_email' => 'This login belongs to another company.']);
            }
        }

        return $validated;
    }

    private function staffAttributes(array $validated): array
    {
        return collect($validated)->only(['first_name', 'last_name', 'email', 'phone', 'role', 'position', 'department_id', 'joined_date', 'status'])->all();
    }

    private function syncAccount(Staff $staff, array $validated): void
    {
        if (empty($validated['account_email'])) {
            return;
        }

        $account = $staff->user()->withTrashed()->first()
            ?? User::withTrashed()->where('email', $validated['account_email'])->first();
        $attributes = [
            'name' => $staff->full_name,
            'email' => $validated['account_email'],
            'role' => strtolower(str_replace(' ', '_', $staff->role)),
            'company_id' => $staff->company_id,
            'staff_id' => $staff->id,
        ];
        if (! empty($validated['password'])) {
            $attributes['password'] = $validated['password'];
        }

        if ($account) {
            $account->update($attributes);
            return;
        }

        User::create([...$attributes, 'password' => $validated['password'] ?? str()->random(24), 'email_verified_at' => now()]);
    }

    private function nextStaffCode(): string
    {
        return 'ST-'.str_pad((string) (Staff::withTrashed()->max('id') + 1), 5, '0', STR_PAD_LEFT);
    }
}
