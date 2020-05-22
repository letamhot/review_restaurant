@include('front-end.partials.head')

<body>

    @yield ('content')

    @stack('js')
    @include('front-end.partials.footer')
</body>


</html>
