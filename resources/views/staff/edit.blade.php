@extends('layouts.app')
@section('title', 'Edit Staff Member')
@section('content')
<div class="mx-auto max-w-4xl space-y-5"><div><a href="{{ route('web.staff.show', $staff) }}" class="text-sm text-primary">← Staff profile</a><h1 class="mt-2 text-2xl font-bold lg:text-3xl">Edit Staff Member</h1><p class="text-gray-500">Update employment details and linked login.</p></div>@include('staff._form')</div>
@endsection
