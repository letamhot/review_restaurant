@extends('layouts.backend.app')

@section('title','Dashboard')

@section('section_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <h3>Content 1</h3>
    @include('backend.layouts.partials.home')
@endsection

@section('section_body')
    <h3>Content 2</h3>
@endsection
