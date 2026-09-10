@extends('layouts.app')
@section('title','Edit Service')
@section('content')
<div class="mx-auto max-w-3xl space-y-5"><div><a class="text-sm text-primary" href="{{ route('web.services.show',$service) }}">← Service</a><h1 class="mt-2 text-2xl font-bold">Edit Service</h1></div>@include('services._form')</div>
@endsection
