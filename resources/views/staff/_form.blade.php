@php($editing = isset($staff) && $staff->exists)
<form method="POST" action="{{ $editing ? route('web.staff.update', $staff) : route('web.staff.store') }}" class="space-y-5">@csrf @if($editing) @method('PUT') @endif
    <section class="rounded-lg border bg-background shadow-sm">
        <div class="border-b p-4"><h2 class="text-xl font-semibold">Employment details</h2><p class="text-sm text-gray-500">Record the staff member's role, department, and contact details.</p></div>
        <div class="grid gap-4 p-4 sm:grid-cols-2">
            <label class="space-y-1"><span class="text-sm font-medium">First name</span><input required name="first_name" value="{{ old('first_name', $staff->first_name ?? '') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label>
            <label class="space-y-1"><span class="text-sm font-medium">Last name</span><input required name="last_name" value="{{ old('last_name', $staff->last_name ?? '') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label>
            <label class="space-y-1"><span class="text-sm font-medium">Work email</span><input required type="email" name="email" value="{{ old('email', $staff->email ?? '') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label>
            <label class="space-y-1"><span class="text-sm font-medium">Phone</span><input name="phone" value="{{ old('phone', $staff->phone ?? '') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label>
            <label class="space-y-1"><span class="text-sm font-medium">Role</span><select required name="role" class="h-10 w-full rounded-md border px-3 text-sm">@foreach($roles as $role)<option value="{{ $role }}" @selected(old('role', $staff->role ?? '') === $role)>{{ $role }}</option>@endforeach</select></label>
            <label class="space-y-1"><span class="text-sm font-medium">Position</span><input name="position" value="{{ old('position', $staff->position ?? '') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label>
            <label class="space-y-1"><span class="text-sm font-medium">Department</span><select name="department_id" class="h-10 w-full rounded-md border px-3 text-sm"><option value="">No department</option>@foreach($departments as $department)<option value="{{ $department->id }}" @selected((string) old('department_id', $staff->department_id ?? '') === (string) $department->id)>{{ $department->name }}</option>@endforeach</select></label>
            <label class="space-y-1"><span class="text-sm font-medium">Joined date</span><input type="date" name="joined_date" value="{{ old('joined_date', isset($staff) ? $staff->joined_date?->toDateString() : today()->toDateString()) }}" class="h-10 w-full rounded-md border px-3 text-sm"></label>
            <label class="space-y-1"><span class="text-sm font-medium">Status</span><select required name="status" class="h-10 w-full rounded-md border px-3 text-sm">@foreach(['Active','On Leave','Inactive'] as $status)<option value="{{ $status }}" @selected(old('status', $staff->status ?? 'Active') === $status)>{{ $status }}</option>@endforeach</select></label>
        </div>
    </section>
    <section class="rounded-lg border bg-background shadow-sm">
        <div class="border-b p-4"><h2 class="text-xl font-semibold">Login account</h2><p class="text-sm text-gray-500">Optionally link an existing unassigned account or create a login.</p></div>
        <div class="grid gap-4 p-4 sm:grid-cols-2">
            <label class="space-y-1"><span class="text-sm font-medium">Account email</span><input type="email" name="account_email" value="{{ old('account_email', $account->email ?? '') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label>
            <label class="space-y-1"><span class="text-sm font-medium">{{ $editing ? 'New password (optional)' : 'Initial password (optional)' }}</span><input type="password" name="password" minlength="8" autocomplete="new-password" class="h-10 w-full rounded-md border px-3 text-sm"></label>
        </div>
    </section>
    <div class="flex justify-end gap-3"><a href="{{ $editing ? route('web.staff.show', $staff) : route('web.staff.index') }}" class="inline-flex h-10 items-center rounded-md border px-4 text-sm">Cancel</a><button class="inline-flex h-10 items-center rounded-md bg-primary px-4 text-sm text-white">{{ $editing ? 'Save changes' : 'Add staff member' }}</button></div>
</form>
