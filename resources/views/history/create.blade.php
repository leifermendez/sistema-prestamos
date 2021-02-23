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
                                <h4 class="widget-title">Historia cierre o movimiento diario</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('history')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="base_amount">Base del cobro:</label>
                                        <input type="text" name="base_amount" value="{{$base}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Recaudo:</label>
                                        <input type="text" name="today" value="{{$today_amount}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Ventas:</label>
                                        <input type="text" name="today" value="{{$today_sell}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Gastos:</label>
                                        <input type="text" name="today" value="{{$bills}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Total Cuadre:</label>
                                        <input type="text" name="today" value="{{$total}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_amount">Efectividad:</label>
                                        <input type="text" name="today" value="{{$average}}" readonly class="form-control" id="base_amount" required>
                                    </div>
                                </form>

                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
