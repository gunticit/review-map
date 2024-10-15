<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>RIVI</title>
        <link rel="icon" type="image/x-icon" href="img/rivi-favicon.png" />

        <!-- css -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,-25" />
        <link href="{{ asset('./assets/css/bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/theme.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('./assets/css/style.css') }}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        @yield('css')
    </head>
    <body class="nav-fixed">

        <!-- js chart-->
        <script src="{{ asset('./assets/js/canvasjs.min.js') }}"></script>
        <!-- jquery -->
        <script src="{{ asset('./assets/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('./assets/js/jquery.basictable.js') }}"></script>
        <script src="{{ asset('./assets/js/select2.min.js') }}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
        <script src="{{ asset('./js/main.js') }}"></script>
        <script src="{{ asset('./js/auth/verifyOtp.js') }}?v={{ time() }}"></script>
        <script src="{{ asset('./js/password.js') }}"></script>
        <script src="{{ asset('./assets/js/map.js') }}"></script>
        <script src="{{ asset('./assets/js/verifyOtp.js') }}?v={{ time() }}"></script>
        @yield('js')
    </body>
</html>
