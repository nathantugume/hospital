@extends('layouts.app')
@section('title','Add Department')
@section('content')
<div class="mx-auto max-w-3xl space-y-5"><div><a class="text-sm text-primary" href="{{ route('web.departments.index') }}">← Departments</a><h1 class="mt-2 text-2xl font-bold">Add Department</h1></div>@include('departments._form',['department'=>new \App\Models\Department()])</div>
@endsection
