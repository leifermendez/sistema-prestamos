<!-- APP ASIDE ==========-->
<aside id="menubar" class="menubar light">
    <div class="app-user">
        <div class="media">
            <div class="media-body">
                <div class="foldable">
                    <h5><a href="javascript:void(0)" class="username"></a></h5>
                </div>
            </div><!-- .media-body -->
        </div><!-- .media -->
    </div><!-- .app-user -->

    <div class="menubar-scroll">
        <div class="menubar-scroll-inner">
            <ul class="app-menu">
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle">
                        <i class="fa fa-suitcase"></i>
                        <span class="menu-text">Trabajos</span>
                        <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ url('admin/work/create')}}"><span class="menu-text">Agregar</span></a></li>
                        <li><a href="{{url('admin/work')}}"><span class="menu-text">Lista</span></a></li>
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle">
                        <i class="fa fa-th"></i>
                        <span class="menu-text">Categorias</span>
                        <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ url('admin/categorie/create')}}"><span class="menu-text">Agregar</span></a></li>
                        <li><a href="{{url('admin/categorie')}}"><span class="menu-text">Lista</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{url('admin/config')}}">
                        <i class="fa fa-gear"></i>
                        <span class="menu-text">Ajustes</span>
                    </a>
                </li>


                <li class="menu-separator"><hr></li>

                <li>
                    <a href="{{url('admin/logout')}}">
                        <i class="fa fa-sign-out"></i>
                        <span class="menu-text">Salir</span>
                    </a>
                </li>


            </ul><!-- .app-menu -->
        </div><!-- .menubar-scroll-inner -->
    </div><!-- .menubar-scroll -->
</aside>
<!--========== END app aside -->
