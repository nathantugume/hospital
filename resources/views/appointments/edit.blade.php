@extends('layouts.app')
@section('title', 'Edit Appointment')
@section('content')
<div class="flex flex-col gap-5"><div class="flex items-center gap-4"><a href="{{ route('web.appointments.show', $appointment) }}" class="inline-flex size-10 items-center justify-center rounded-md border border-gray-300" aria-label="Back">←</a><div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Edit Appointment</h1><p class="text-gray-500">Reschedule or update this visit.</p></div></div>@include('appointments._form')</div>
@endsection
