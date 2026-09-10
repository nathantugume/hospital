@extends('layouts.app')

@section('title', 'Add Doctor')
@section('header', 'Add doctor')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex items-center flex-wrap gap-4">
        <a href="{{ route('web.doctors.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground size-10" aria-label="Back to doctors">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-gray-900">Add Doctor</h1>
            <p class="text-gray-500">Add a new doctor to your clinic.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('web.doctors.store') }}">
        @csrf
        @include('doctors._form')

        <div class="flex justify-end gap-4 mt-5">
            <a href="{{ route('web.doctors.index') }}" class="border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm inline-flex items-center">Cancel</a>
            <button type="submit" class="bg-primary text-white hover:bg-primary/90 px-6 py-2 rounded-md text-sm font-medium shadow-sm">Save Doctor</button>
        </div>
    </form>
</div>
@endsection
