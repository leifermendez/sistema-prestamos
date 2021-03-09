<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{config("app.name")}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Admin, Dashboard, Bootstrap" />
    <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png">

    <link rel="stylesheet" href="{{ asset('libs/bower/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bower/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/misc-pages.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
</head>
<body class="simple-page">
<div class="simple-page-wrap">
    <div class="simple-page-form animated flipInY" id="login-form">
{{--        <div class="simple-page-logo animated swing">--}}
{{--            <a href="{{config("app.url")}}">--}}
{{--                <span><img src="{{asset('assets/images/zeus-logo.png')}}" alt=""></span>--}}
{{--            </a>--}}
{{--        </div><!-- logo -->--}}
        <h4 class="form-title m-b-xl text-center">Iniciar Sesion</h4>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input id="email" type="text" class="form-control" name="email" placeholder="Usuario" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" placeholder="Contraseña" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="keep_me_logged_in" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="keep_me_logged_in">Mantener Sesion</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>

                    </div>
                </div>
            </form>
        </div>
        <form class="d-none" action="#">
            <div class="form-group">
                <input id="sign-in-email" type="email" class="form-control" placeholder="Email">
            </div>

            <div class="form-group">
                <input id="sign-in-password" type="password" class="form-control" placeholder="Password">
            </div>

            <div class="form-group m-b-xl">
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" id="keep_me_logged_in"/>
                    <label for="keep_me_logged_in">Mantener sesion</label>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="SING IN">
        </form>
    </div><!-- #login-form -->

    <div class="simple-page-footer">
        <p><a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a></p>
    </div><!-- .simple-page-footer -->


</div><!-- .simple-page-wrap -->
</body>
</html>
