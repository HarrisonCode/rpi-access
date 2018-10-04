<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Nosco Access System</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        @yield('content')
        
        <script>
            var baseUrl = '{{ asset('') }}';
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('script')
    </body>
</html>
