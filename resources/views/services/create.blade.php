@extends('layouts.app')
@section('title','Add Service')
@section('content')
<div class="mx-auto max-w-3xl space-y-5"><div><a class="text-sm text-primary" href="{{ route('web.services.index') }}">← Services</a><h1 class="mt-2 text-2xl font-bold">Add Service</h1></div>@include('services._form',['service'=>new \App\Models\Service()])</div>
@endsection
