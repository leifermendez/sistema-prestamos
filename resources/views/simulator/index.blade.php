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
                                <h4 class="widget-title">Simulador</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('summary')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="amount">Monto:</label>
                                        <input type="number" step="any" min="1" name="amount" class="form-control amount-input" id="amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="utility">Utilidad:</label>
                                        <select name="utility" class="form-control" id="utility">
                                            <option value="0.05">5%</option>
                                            <option value="0.1">10%</option>
                                            <option value="0.15">15%</option>
                                            <option value="0.2">20%</option>
                                            <option value="0.25">25%</option>
                                            <option value="0.30">30%</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_number">Cuotas:</label>
                                        <select name="payment_number" class="form-control" id="payment_number">
                                            @foreach($payment as $p)
                                                <option value="{{$p->name}}">{{$p->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group text-center total-box hidden">
                                        <h4>Total + Utilidad</h4>
                                        <h2 id="total_show"></h2>
                                        <h4>Cuota</h4>
                                        <h2 id="quote"></h2>
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
