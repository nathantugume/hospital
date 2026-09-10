@extends('layouts.app')

@section('title', 'Settings')
@section('header', 'System settings')

@section('content')
<div class="flex flex-col gap-5">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">System settings</h1>
        <p class="text-gray-500">Configure defaults used across the hospital workspace.</p>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold flex items-center">
                <svg class="mr-2 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2v20"/><path d="M2 12h20"/></svg>
                Currency Settings
            </h2>
            <p class="text-gray-500">Choose the display currency for dashboard and billing totals.</p>
        </div>
        <div class="p-4 space-y-4 max-w-lg">
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label for="currency" class="text-sm font-medium">Base Currency</label>
                    <select id="currency" name="currency" required class="w-full h-10 rounded-md border border-gray-300 bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach ($currencies as $code => $definition)
                            <option value="{{ $code }}" @selected($currency->code() === $code)>{{ $code }} - {{ $definition['name'] }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500">Select your clinic's base currency</p>
                </div>
                <p class="text-sm text-gray-500">Preview: <strong class="text-gray-900">@money(125000)</strong></p>
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm">Save currency</button>
            </form>
        </div>
    </div>
</div>
@endsection
