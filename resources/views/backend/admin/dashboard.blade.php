@extends('layouts.backend.app')

@section('title','Dashboard')

@push('css')
<!-- JQuery DataTable Css -->
@endpush

@section('section_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <h3>Content 1</h3>
    @include('layouts.backend.partials.home')
@endsection

@section('section_body')
    <h3>Content 2</h3>
@endsection

@push('js')
    <!-- JQuery DataTable JS -->
    <script src="{{ asset('assets/backend/js/page/index-0.js') }}"></script>
@endpush