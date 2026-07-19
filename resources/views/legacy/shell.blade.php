@extends('layouts.app')

@section('title', $legacyTitle)
@section('header', $legacyTitle)

@section('head')
    {!! $legacyHead !!}
@endsection

@section('content')
    <div class="legacy-page" data-legacy-page="{{ $legacyPage }}">
        {!! $legacyContent !!}
    </div>
@endsection

@push('scripts')
    {!! $legacyScripts !!}
@endpush
