<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Review') }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/backend/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/modules/fontawesome/css/all.min.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/style.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/components.min.css')}}">

    @stack('css')
</head>

<body>
    <div id="app">
      <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        <!-- Nav bar -->
        @include('layouts.backend.partials.nav')

        <!-- Main sidebar -->
         @include('layouts.backend.partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    @yield('section_header')
                </div>
                <div>
                    @yield('content')
                </div>
                <div class="section-body">
                    @yield('section_body')
                </div>
            </section>
        </div>
       <div>
           @include('layouts.backend.partials.footer')
       </div>
        </div>
    </div>
  <!-- General JS Scripts -->
    <script src="{{ asset('assets/backend/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/stisla.js') }}"></script>

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="{{ asset('assets/backend/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/backend/js/custom.js') }}"></script>


  @stack('js')
</body>
</html>




