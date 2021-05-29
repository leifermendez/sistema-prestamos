@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg overflow-auto">
                            <h4 class="m-b-lg">Clientes y Creditos</h4>

                            <div class="d-none d-lg-block d-xl-block">
                                <table class="table supervisor-route-table">
                                    <thead>
                                        <tr>
                                            <th>Credito</th>
                                            <th>Nombres</th>
                                            <th>Fecha de prestamos</th>
                                            <th>Cuota diaria</th>
                                            <th>Dias sin pagar</th>
                                            <th>Valor</th>
                                            <th>Saldo</th>
                                            <th>Barrio</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->user->name}} {{$client->user->last_name}}</td>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->quote}}</td>
                                        <td>{{$client->rest_days}}</td>
                                        <td>{{$client->amount_neto}}</td>
                                        <td>{{$client->saldo}}</td>
                                        <td>{{$client->user->province}}</td>
                                        <td>
                                            @if($client->user->status=='good')
                                                <span class="badge-info badge">BUENO</span>
                                            @elseif($client->user->status=='bad')
                                                <span class="badge-danger badge">MALO</span>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{url('supervisor/menu/history')}}/{{$client->id}}" class="btn btn-info btn-xs"><i class="fa fa-history"></i> Ver</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                            </div>

{{--                            MOBILE--}}
                            <div class="d-sm-block d-lg-none">
                                <table class="table supervisor-route-table">
                                    <thead class="d-none">
                                        <tr>
                                            <th>Credito</th>
                                            <th>Nombres</th>
                                            <th>Fecha de prestamos</th>
                                            <th>Cuota diaria</th>
                                            <th>Dias sin pagar</th>
                                            <th>Valor</th>
                                            <th>Saldo</th>
                                            <th>Barrio</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->user->name}} {{$client->user->last_name}}</td>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->quote}}</td>
                                        <td>{{$client->rest_days}}</td>
                                        <td>{{$client->amount_neto}}</td>
                                        <td>{{$client->saldo}}</td>
                                        <td>{{$client->user->province}}</td>
                                        <td>
                                            @if($client->user->status=='good')
                                                <span class="badge-info badge">BUENO</span>
                                            @elseif($client->user->status=='bad')
                                                <span class="badge-danger badge">MALO</span>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{url('supervisor/menu/history')}}/{{$client->id}}" class="btn btn-info btn-xs"><i class="fa fa-history"></i> Ver</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                            </div>

                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
                <div class="col-lg-12 text-right">
                    <a href="{{url('supervisor/review/')}}/{{$id_wallet}}" class="btn btn-inverse"><i class="fa fa-arrow-left"></i> Regresar</a>
                </div>
            </section>
        </div>
    </main>
@endsection
