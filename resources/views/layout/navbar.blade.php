<nav id="app-navbar" class="navbar navbar-inverse navbar-fixed-top primary in">

    <!-- navbar header -->
    <div class="navbar-header">
        <a href="{{url('/home')}}" class="navbar-toggle visible-xs-inline-block navbar-toggle-left hamburger hamburger--collapse js-hamburger">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-box"><i class="fa fa-home fa-2x"></i></span>
        </a>

        <a href="{{url('logout')}}" class="navbar-toggle navbar-toggle-right collapsed" aria-expanded="false">
            <i class="fa fa-sign-out fa-2x"></i>
        </a>



        <a href="{{url('home')}}" class="navbar-brand">
            <span class="brand-icon">{{Auth::user()->name}}</span>
        </a>
    </div><!-- .navbar-header -->

</nav>
