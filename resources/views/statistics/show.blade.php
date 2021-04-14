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
                                <h4 class="widget-title">Estadistica</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('history')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="wallet"> Cartera:</label>
                                        <input type="text" name="wallet" value="{{$wallet->name}}" readonly class="form-control" id="wallet" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="average">Promedio Recaudado:</label>
                                        <input type="text" name="average" value="{{$summary}}" readonly class="form-control" id="average" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sell">Promedio Ventas:</label>
                                        <input type="text" name="sell" readonly value="{{$credit}}" class="form-control" id="sell" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sell">Promedio Gastos:</label>
                                        <input type="text" name="sell" readonly value="{{$bills}}" class="form-control" id="sell" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="days">Cantidad días:</label>
                                        <input type="text" name="days" value="{{$days}}" readonly class="form-control" id="days" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="days">Fechas:</label>
                                        <input type="text" name="days" value="{{$range}}" readonly class="form-control" id="days" required>
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
