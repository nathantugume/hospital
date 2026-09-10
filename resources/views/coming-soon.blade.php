@extends('layouts.app')

@section('title', $featureTitle)
@section('header', $featureTitle)

@section('content')
<div class="flex flex-col items-center justify-center text-center py-20 px-4">
    <div class="rounded-full bg-gray-100 p-4 mb-4">
        <svg class="h-8 w-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
    </div>
    <h1 class="text-2xl font-bold tracking-tight text-gray-900">{{ $featureTitle }} is coming soon</h1>
    <p class="text-gray-500 mt-2 max-w-md">We're still building this part of MediTrack. It'll be wired up with real data soon &mdash; check back later.</p>
    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm mt-6">Back to dashboard</a>
</div>
@endsection
