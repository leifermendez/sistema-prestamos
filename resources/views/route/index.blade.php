@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Clientes y Creditos</h4>
                            <table class="table agente-route-table">
                                <tbody>
                                <tr>
                                    <th>Credito</th>
                                    <th>Nombres</th>
                                    <th>Días en mora</th>
                                    <th>Cuato diaria</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                    <th>Ultimo pago</th>
                                    <th>Barrio</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->user->name}} {{$client->user->last_name}}</td>
                                        <td>{{$client->days_rest}}</td>
                                        <td>{{$client->quote}}</td>
                                        <td>{{$client->amount_total}}</td>
                                        <td>{{$client->saldo}}</td>
                                        @if($client->last_pay)
                                            <td>{{$client->last_pay}}</td>
                                        @else
                                            <td>No hay pagos</td>
                                        @endif
                                        <td>{{$client->user->province}}</td>
                                        <td>
                                            @if($client->user->status=='good')
                                                <span class="badge-info badge">BUENO</span>
                                            @elseif($client->user->status=='bad')
                                                <span class="badge-danger badge">MALO</span>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{url('payment')}}/{{$client->id_user}}/edit?id_credit={{$client->id}}" class="btn btn-warning btn-xs"><i class="fa fa-archive"></i> Saltar</a>
                                            <a href="{{url('payment')}}/{{$client->id}}" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Pagar</a>
                                            <a href="{{url('summary')}}?id_credit={{$client->id}}" class="btn btn-info btn-xs"><i class="fa fa-history"></i> Ver</a>
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
