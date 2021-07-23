@extends('layouts.app')

@section('content')
    <!-- Load all javascript -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <div id="app">
        <app></app>
    </div>
@endsection
