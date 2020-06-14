@extends('layouts.app')

@section('content')
    <main id="app-main" class="app-main in">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <a href="{{url('client/create')}}">
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
                        <a href="{{url('client')}}">
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
                        <a href="{{url('simulator')}}">
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
                        <a href="{{url('payment')}}">
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
                        <a href="{{url('route')}}">
                            <div class="widget stats-widget">
                                <div class="widget-body clearfix bg-inverse">
                                    <div class="pull-left">
                                        <h3 class="widget-title text-white">Cierre</h3>
                                    </div>
                                    <span class="pull-right big-icon watermark"><i class="fa fa-lock"></i></span>
                                </div>
                            </div><!-- .widget -->
                        </a>

                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{url('history')}}">
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
                        <a href="{{url('transaction')}}">
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
                        <a href="{{url('bill')}}">
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

        <!-- /#app-footer -->
    </main>
@endsection
