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

    <!-- CSS for specific page -->
    @stack('css')
    @stack('css-post')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/style.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/components.min.css')}}">
    
    <!-- Custom JS in header for specific page -->
    @stack('head_js')
    

</head>

<body>
    <!-- App -->
    <div id="app">
        <!-- Custom for error/auth page -->
        @if (isset($exception) || Request::is(['password/*','login']) )
            <section class="section">
                <div class="container mt-5">
                    <!-- Custom content -->
                    @yield('custom_content')
                    <div class="simple-footer mt-5">
                        Copyright &copy; TLP Team 2020
                    </div>
                </div>
            </section>
        </div> <!-- End App -->
        @else

        <!-- Main dashboard page -->
        <div class="main-wrapper main-wrapper-1">
            <!-- Background for Nav bar -->
            <div class="navbar-bg"></div>

            <!-- Nav bar -->
            @include('backend.layouts.partials.nav')

            <!-- Main sidebar -->
            @include('backend.layouts.partials.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <!-- Head Content -->
                    <div class="section-header">
                        @yield('section_header')
                    </div>
                    <!-- Sub-Head Content -->
                    <div>
                        @yield('content')
                    </div>
                    <!-- Body Content -->
                    <div class="section-body">
                        @yield('section_body')
                    </div>
                </section>
            </div>
           
            <!-- Modal Bootstrap Dialog -->
            @yield('modal_content')

            <!-- Footer -->
            <div>
                @include('backend.layouts.partials.footer')
            </div>
        </div>
    </div> <!-- End App -->
    
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/backend/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/stisla.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('assets/backend/js/scripts.js') }}"></script>
    @endif

    <!-- Custom JS File -->
    @stack('js')
    @stack('js-post')
    @stack('js-role')
</body>

</html>