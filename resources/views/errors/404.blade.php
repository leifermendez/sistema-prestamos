<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Admin, Dashboard, Bootstrap" />
    <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png">
    <title>{{config("app.name")}}</title>

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
    <meta name="theme-color" content="#42A5F5">

    <!-- endbuild -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
    <script src="{{asset('libs/bower/breakpoints.js/dist/breakpoints.min.js')}}"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="simple-page">
<div id="back-to-home">
    <a href="index.html" class="btn btn-outline btn-default"><i class="fa fa-home animated zoomIn"></i></a>
</div>
<div class="simple-page-wrap">
    <div class="simple-page-logo animated swing">
        <a href="index.html">
            <span><i class="fa fa-gg"></i></span>
            <span>Infinity</span>
        </a>
    </div><!-- logo -->
    <h1 id="_404_title" class="animated shake">404</h1>
    <h5 id="_404_msg" class="animated slideInUp">Oops, an error occur. The page can't be found</h5>
    <div id="_404_form" class="animated slideInUp">
        <form action="#">
            <div class="input-group">
                <input type="search" class="form-control" placeholder="search">
                <div class="input-group-addon"><i class="fa fa-search"></i></div>
            </div>
        </form>
    </div>


</div><!-- .simple-page-wrap -->

</body>
