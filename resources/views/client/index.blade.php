@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Detalles Clientes y Ventas</h4>
                            <table class="table client-table">
                                <thead class="visible-lg">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Barrio</th>
                                    <th>Total</th>
                                    <th>Pagados</th>
                                    <th>Vigentes</th>
                                    <th>Monto Prestado</th>
                                    <th>Monto Restante</th>
                                    <th>Tipo</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td><span class="value">{{$client->name}}</span></td>
                                        <td><span class="value">{{$client->last_name}}</span></td>
                                        <td><span class="value">{{$client->province}}</span></td>
                                        <td><span class="value">{{$client->credit_count}}</span></td>
                                        <td><span class="value">{{$client->closed}}</span></td>
                                        <td><span class="value">{{$client->inprogress}}</span></td>
                                        <td><span class="value">{{isset($client->amount_net) ? $client->amount_net->amount_neto +$client->gap_credit : 0}}</span></td>
                                        <td><span class="value">{{$client->summary_net + $client->gap_credit}}</span></td>
                                        <td>
                                            @if($client->status=='good')
                                                <span class="badge-info badge">BUENO</span>
                                            @elseif($client->status=='bad')
                                                <span class="badge-danger badge">MALO</span>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{url('client/create')}}?id={{$client->id}}" class="btn btn-success btn-xs">Venta</a>
                                            <a href="{{url('client')}}/{{$client->id}}" class="btn btn-info btn-xs">Datos</a>
                                            @if(isset($client->lat) && isset($client->lng))
                                                <a href="http://www.google.com/maps/place/{{$client->lat}},{{$client->lng}}" target="_blank" class="btn btn-info btn-xs">Ver Mapa</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
