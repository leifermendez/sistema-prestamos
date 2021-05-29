@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg overflow-auto">
                            <h4 class="m-b-lg">Detalles Clientes y Prestamos</h4>

                            <div class="d-none d-lg-block d-xl-block">
                                <table class="table client-table">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Apellidos</th>
                                                <th>Tipo de Negocio</th>
                                                <th>Total Prestamos</th>
                                                <th>Prestamos Terminados</th>
                                                <th>Prestamos Vigentes</th>
                                                <th>Monto Prestado</th>
                                                <th>Saldo Actual</th>
                                                <th>Status</th>
                                                <th>Acción</th>
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
                                            <td><span
                                                    class="value">{{($client->amount_net) ? $client->sum_amount_gap : 0}}</span>
                                            </td>
                                            <td><span class="value">{{$client->summary_net + $client->gap_credit}}</span></td>
                                            <td>
                                                @if($client->status=='good')
                                                <span class="badge-info badge">BUENO</span>
                                                @elseif($client->status=='bad')
                                                <span class="badge-danger badge">MALO</span>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="{{url('client/create')}}?id={{$client->id}}"
                                                    class="btn btn-success btn-xs">Prestar</a>
                                                <a href="{{url('client')}}/{{$client->id}}"
                                                    class="btn btn-info btn-xs">Datos</a>
                                                @if(isset($client->lat) && isset($client->lng))
                                                <a href="http://www.google.com/maps/place/{{$client->lat}},{{$client->lng}}"
                                                    target="_blank" class="btn btn-info btn-xs">Ver Mapa</a>
                                                @endif

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-sm-block d-lg-none">
                                <table class="table client-table">
                                    <thead class="d-none">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Tipo de Negocio</th>
                                            <th>Total Prestamos</th>
                                            <th>Prestamos Terminados</th>
                                            <th>Prestamos Vigentes</th>
                                            <th>Monto Prestado</th>
                                            <th>Saldo Actual</th>
                                            <th>Status</th>
                                            <th>Acción</th>
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
                                            <td><span
                                                        class="value">{{($client->amount_net) ? $client->sum_amount_gap : 0}}</span>
                                            </td>
                                            <td><span class="value">{{$client->summary_net + $client->gap_credit}}</span></td>
                                            <td>
                                                @if($client->status=='good')
                                                    <span class="badge-info badge">BUENO</span>
                                                @elseif($client->status=='bad')
                                                    <span class="badge-danger badge">MALO</span>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="{{url('client/create')}}?id={{$client->id}}"
                                                   class="btn btn-success btn-xs">Prestar</a>
                                                <a href="{{url('client')}}/{{$client->id}}"
                                                   class="btn btn-info btn-xs">Datos</a>
                                                @if(isset($client->lat) && isset($client->lng))
                                                    <a href="http://www.google.com/maps/place/{{$client->lat}},{{$client->lng}}"
                                                       target="_blank" class="btn btn-info btn-xs">Ver Mapa</a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="w-100 mx-auto mt-4 alert alert-info d-flex justify-content-between">
                                <p class="m-0">Cartera total</p>
                                <h5 class="m-0">{{$total_pending}}</h5>
                            </div>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection