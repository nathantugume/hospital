@extends('layouts.app')
@section('title', 'Add Staff Member')
@section('content')
<div class="mx-auto max-w-4xl space-y-5"><div><a href="{{ route('web.staff.index') }}" class="text-sm text-primary">← Care team</a><h1 class="mt-2 text-2xl font-bold lg:text-3xl">Add Staff Member</h1><p class="text-gray-500">Create a non-doctor care-team record and optional login.</p></div>@include('staff._form', ['staff' => new \App\Models\Staff(), 'account' => null])</div>
@endsection
