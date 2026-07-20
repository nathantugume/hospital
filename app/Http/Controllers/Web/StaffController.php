<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(Request $request): View
    {
        $staff = Staff::query()
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
            'active' => Staff::where('status', 'Active')->count(),
            'doctors' => Staff::where('status', 'Active')->whereIn('role', ['Doctor', 'doctor'])->count(),
            'departments' => Department::where('status', 'Active')->count(),
            'on_leave' => Staff::where('status', 'On Leave')->count(),
        ];
        $departments = Department::where('status', 'Active')->orderBy('name')->get(['id', 'name']);

        return view('staff.index', compact('staff', 'stats', 'departments'));
    }
}
