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
                                <h4 class="widget-title">Nueva venta</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('client')}}" class="new-register"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="nit_number">Nº Identificacion:</label>
                                        <input type="text" name="nit_number" value="{{isset($user) ? $user->nit : ''}}"
                                               class="form-control" id="nit_number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nombres:</label>
                                        <input type="text" name="name" value="{{isset($user) ? $user->name : ''}}"
                                               class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Apellidos:</label>
                                        <input type="text" name="last_name"
                                               value="{{isset($user) ? $user->last_name : ''}}" class="form-control"
                                               id="last_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Direccion:</label>
                                        <input type="text" name="address" value="{{isset($user) ? $user->address : ''}}"
                                               placeholder="" class="form-control g-autoplaces-address" id="address"
                                               required>
                                    </div>
                                    <div class="form-group d-none over-change-display">
                                        <label for="address">Mapa:</label>
                                        <div id="map" class="map-google"></div>
                                    </div>
                                    <input type="hidden" name="lat" value="{{isset($user) ? $user->lat : ''}}"
                                           class="form-control" id="lat">
                                    <input type="hidden" name="lng" value="{{isset($user) ? $user->lng : ''}}"
                                           class="form-control" id="lng">
                                    <div class="form-group">
                                        <label for="province">Barrio:</label>
                                        <input type="text" name="province"
                                               value="{{isset($user) ? $user->province : ''}}" class="form-control"
                                               id="province" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Teléfono:</label>
                                        <input type="tel" name="phone" value="{{isset($user) ? $user->phone : ''}}"
                                               class="form-control" id="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Monto:</label>
                                        <input type="number" step="any" min="1" name="amount"
                                               class="form-control amount-input" id="amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="utility">Utilidad:</label>
                                        <select name="utility" class="form-control" id="utility">
                                            <option value="0.0">0%</option>
                                            <option value="0.05">5%</option>
                                            <option value="0.1">10%</option>
                                            <option value="0.15">15%</option>
                                            <option value="0.2" selected>20%</option>
                                            <option value="0.25">25%</option>
                                            <option value="0.30">30%</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_number">Cuotas:</label>
                                        <select name="payment_number" class="form-control" id="payment_number">
                                            @foreach($payment_number as $p)
                                                <option {{($p->selected) ? 'selected':'' }} value="{{$p->name}}">{{$p->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group text-center total-box hidden">
                                        <h4>Total + Utilidad</h4>
                                        <h2 id="total_show"></h2>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block btn-md">Guardar</button>
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
