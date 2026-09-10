@extends('layouts.app')
@section('title','Edit Department')
@section('content')
<div class="mx-auto max-w-3xl space-y-5"><div><a class="text-sm text-primary" href="{{ route('web.departments.show',$department) }}">← Department</a><h1 class="mt-2 text-2xl font-bold">Edit Department</h1></div>@include('departments._form')</div>
@endsection
