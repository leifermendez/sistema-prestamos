@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12 col-lg-8 offset-lg-2">
                        <div class="widget">
                            <header class="widget-header">
                                <h4 class="widget-title">Cierre</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="GET" action="{{url('history')}}" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="base_amount">Base del cobro:</label>
                                        <input type="text" name="base_amount" value="{{($base) ? $base : 'No existe cierre del día'}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Recaudo:</label>
                                        <input type="text" name="today" value="{{($base) ? $today_amount : 'No existe cierre del día'}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Ventas:</label>
                                        <input type="text" name="today" value="{{($base) ? $today_sell : 'No existe cierre del día' }}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Gastos:</label>
                                        <input type="text" name="today" value="{{($base) ? $bills : 'No existe cierre del día' }}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Total Cuadre:</label>
                                        <input type="text" name="today" value="{{($base) ? $total : 'No existe cierre del día'}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Efectividad:</label>
                                        <input type="text" name="today" value="{{($base) ? $average : 'No existe cierre del día'}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                </form>

                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div><!-- END column -->
                </div><!-- .row -->
                <div class="col-lg-12 text-right">
                    <a href="{{url('supervisor/review/')}}/{{$id_wallet}}" class="btn btn-inverse"><i class="fa fa-arrow-left"></i> Regresar</a>
                </div>
            </section>
        </div>
    </main>
@endsection
