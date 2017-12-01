@extends('layouts.app')

@section('content')
    <main id="app-main" class="app-main in">
        <div class="wrap">
            <section class="app-content">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/history/')}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-info">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Historia de credito</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-history"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>

                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/transitions/create')}}?id_wallet={{$id}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-purple">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Transacciones</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-check-square-o"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>

                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/route')}}?id_wallet={{$id}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-success">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Ruta</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-car"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>

                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/bill')}}/{{$id}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-pink">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Gastos</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-money"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>

                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/close')}}?id_wallet={{$id}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-inverse">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Historial de Cierre</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-lock"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>

                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/edit/create')}}?id_wallet={{$id}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-danger">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Modificar</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-edit"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/report')}}/{{$id}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-info">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Movimiento</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-list-ol"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>

                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{url('supervisor/menu/done')}}/{{$id}}">
                                <div class="widget stats-widget">
                                    <div class="widget-body clearfix bg-deepOrange">
                                        <div class="pull-left">
                                            <h3 class="widget-title text-white">Pagados</h3>
                                        </div>
                                        <span class="pull-right big-icon watermark"><i class="fa fa-times"></i></span>
                                    </div>
                                </div><!-- .widget -->
                            </a>

                        </div>

                    </div><!-- .row -->
            </section><!-- #dash-content -->
        </div><!-- .wrap -->
        <!-- APP FOOTER -->
        <div class="wrap p-t-0">
            <footer class="app-footer">
                <div class="clearfix">
                    <ul class="footer-menu pull-right">
                        <li><a href="javascript:void(0)">Careers</a></li>
                        <li><a href="javascript:void(0)">Privacy Policy</a></li>
                        <li><a href="javascript:void(0)">Feedback <i class="fa fa-angle-up m-l-md"></i></a></li>
                    </ul>
                    <div class="copyright pull-left">Copyright RaThemes 2016 ©</div>
                </div>
            </footer>
        </div>
        <!-- /#app-footer -->
    </main>
@endsection
