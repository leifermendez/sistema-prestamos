<nav id="app-navbar" class="navbar navbar-inverse navbar-fixed-top primary in">

    <!-- navbar header -->
    <div class="navbar-header">

        <a href="{{url('logout')}}" class="navbar-toggle navbar-toggle-right collapsed">
            <i class="fa fa-2x fa-sign-out"></i>
        </a>

        <a href="{{url('/')}}" class="navbar-brand">
            {{Auth::user()->name}}
        </a>
    </div><!-- .navbar-header -->

    <div class="navbar-container container-fluid">
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
                <li class="hidden-float hidden-menubar-top">
                    <a href="javascript:void(0)" role="button" id="menubar-fold-btn" class="hamburger hamburger--arrowalt is-active js-hamburger">
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
