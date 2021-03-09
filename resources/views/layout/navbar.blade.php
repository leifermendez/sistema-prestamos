@php
    use Illuminate\Support\Facades\Crypt;
        $cookie = \Illuminate\Support\Facades\Cookie::get('forward_session');
        if($cookie){
            $decrypted = Crypt::decryptString($cookie);
            $parse_decrypted= explode('-',$decrypted);
            $gap_time = \Carbon\Carbon::createFromTimestamp($parse_decrypted[1]);
            $now = \Carbon\Carbon::now();
            $valid = $gap_time->gte($now);
        }

@endphp
<nav id="app-navbar" class="  navbar-inverse navbar-fixed-top primary in">

    <!-- navbar header -->
    <div class="navbar-header">

        <a href="{{url('logout')}}" class="navbar-toggle navbar-toggle-right collapsed p-3">
            <i class="fa fa-2x fa-sign-out"></i>
        </a>

        <a href="{{url('/')}}" class="navbar-brand text-white">
            {{Auth::user()->name}}
        </a>
    </div><!-- .navbar-header -->

    <div class="navbar-container container-fluid">
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
                <li class="hidden-float hidden-menubar-top">
                    <a href="javascript:void(0)" role="button" id="menubar-fold-btn"
                       class="hamburger hamburger--arrowalt is-active js-hamburger">
                        <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                    </a>
                </li>
                <li>
                    <h5 class="page-title hidden-menubar-top">Dashboard</h5>
                </li>
            </ul>

            <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">

                <li class="dropdown">
                    <a href="{{url('logout')}}"><i class="fa fa-sign-out fa-2x"></i></a>
                </li>
            </ul>

        </div><!-- navbar-container -->
</nav>
@if(isset($valid) && $valid)
    <div class="section-session">
        <div>
            Estás haciendo uso de la cuenta administradora, recuerda que la sesión es válida por 15 min
        </div>
        <form action="{{url('admin/session')}}" method="POST"
              class="pull-left px-1">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-inverse btn-xs">Volver
            </button>
        </form>
    </div>
@endif