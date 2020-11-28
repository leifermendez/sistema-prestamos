<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Leifer Mendez, github, sistema prestamos, https://github.com/leifermendez" />
    <meta name="author" content="https://github.com/leifermendez" />
    <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png">
    <title>{{config("app.name")}} | Sistema de reporte (Leifer Mendez)  https://github.com/leifermendez</title>

    <link rel="stylesheet" href="{{ asset('libs/bower/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css') }}">
    <!-- build:css ../assets/css/app.min.css -->
    <link rel="stylesheet" href="{{ asset('libs/bower/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bower/fullcalendar/dist/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bower/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#42A5F5">

    <!-- endbuild -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="{{asset('libs/bower/breakpoints.js/dist/breakpoints.min.js')}}"></script>
    <script>
        Breakpoints();
    </script>
</head>

<body class="theme-primary menubar-light pace-done menubar-top">
<!--============= start main area -->
@include('layout.navbar')

@include('layout.navbarsearch')

@yield('content')

@include('layout.sidepanel')

</body>

@include('layout.script')

</html>
