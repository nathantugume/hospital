@extends('layouts.app')

@section('title', 'Edit Patient')
@section('header', 'Edit patient')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex items-center flex-wrap gap-4">
        <a href="{{ route('web.patients.show', $patient) }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground size-10" aria-label="Back to patient">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-gray-900">Edit Patient</h1>
            <p class="text-gray-500">{{ $patient->full_name }} &middot; {{ $patient->code }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('web.patients.update', $patient) }}">
        @csrf
        @method('PUT')
        @include('patients._form')

        <div class="flex justify-end gap-4 mt-5">
            <a href="{{ route('web.patients.show', $patient) }}" class="border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm inline-flex items-center">Cancel</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary/90 px-4 py-2 rounded-md text-sm">Save Changes</button>
        </div>
    </form>
</div>
@endsection
