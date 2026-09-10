<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RoleChangeLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    public const ROLES = ['admin', 'doctor', 'nurse', 'receptionist', 'lab_technician', 'pharmacist', 'accountant', 'insurance_officer', 'inventory_manager', 'hr_manager', 'radiology_technician', 'physiotherapist', 'surgeon', 'blood_bank_staff', 'ambulance_dispatcher', 'ambulance_driver'];

    public function index(Request $request): View
    {
        abort_unless($request->user()->hasRole(['admin', 'super_admin']), 403);
        $users = User::query()->when(! $request->user()->isSuperAdmin(), fn ($q) => $q->where('company_id', $request->user()->company_id))->with(['staff', 'company'])->orderBy('name')->paginate(20);
        $logs = RoleChangeLog::query()->with(['user', 'changedBy'])->when(! $request->user()->isSuperAdmin(), fn ($q) => $q->whereHas('user', fn ($u) => $u->where('company_id', $request->user()->company_id)))->latest('date')->limit(20)->get();
        return view('roles.index', ['users' => $users, 'logs' => $logs, 'roles' => $request->user()->isSuperAdmin() ? array_merge(['super_admin'], self::ROLES) : self::ROLES]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($request->user()->hasRole(['admin', 'super_admin']), 403);
        abort_unless($request->user()->isSuperAdmin() || $user->company_id === $request->user()->company_id, 403);
        $roles = $request->user()->isSuperAdmin() ? array_merge(['super_admin'], self::ROLES) : self::ROLES;
        $data = $request->validate(['role' => ['required', Rule::in($roles)]]);
        abort_if($user->is($request->user()) && $user->role === 'super_admin' && $data['role'] !== 'super_admin', 422, 'You cannot remove your own super administrator role.');
        $previous = $user->role;
        if ($previous !== $data['role']) {
            DB::transaction(function () use ($user, $request, $previous, $data): void {
                $user->update(['role' => $data['role']]);
                RoleChangeLog::create(['user_id' => $user->id, 'changed_by' => $request->user()->id, 'user_name' => $user->name, 'prev_role' => $previous, 'new_role' => $data['role'], 'date' => now()]);
            });
        }
        return back()->with('status', 'Role updated successfully.');
    }
}
