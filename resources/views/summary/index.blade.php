@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" p-lg text-right">
                            <a type="button" href="{{url('client')}}" class="btn btn-inverse"><i class="fa fa-users"></i> Mostar clientes</a>
                            <a type="button" href="{{url('route')}}" class="btn btn-deepOrange"><i class="fa fa-car"></i> Continuar ruta</a>
                        </div><!-- .widget -->
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">{{$user->name}} {{$user->last_name}}</h4>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">Credito: <span class="text-purple">{{$credit_data->id}}</span></li>
                                <li class="list-group-item">Fecha de venta: <span class="text-purple">{{$credit_data->created_at}}</span></li>
                                <li class="list-group-item">Tasa de interés: <span class="text-purple">{{$credit_data->utility}}%</span></li>
                                <li class="list-group-item">Cuotas pactadas: <span class="text-purple">{{$credit_data->payment_number}}</span></li>
                                <li class="list-group-item">Valor cuota: <span class="text-purple">{{$credit_data->payment_amount}}</span></li>
                                <li class="list-group-item">Capital: <span class="text-purple">{{$credit_data->amount_neto}}</span></li>
                                <li class="list-group-item">Intereses: <span class="text-purple">{{$credit_data->utility_amount}}</span></li>
                                <li class="list-group-item">Total: <span class="text-purple">{{$credit_data->total}}</span></li>

                            </ul>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Historial</h4>
                            <table class="table agente-paymentsH-table">
                                <tbody>
                                <tr>
                                    <th>Fecha</th>
                                    <th>No</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                    <th></th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->number_index}}</td>
                                        <td>{{$client->amount}}</td>
                                        <td>{{$client->rest}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Otros creditos</h4>
                            @foreach($other_credit as $c)
                                @if((app('request')->input('id_credit'))!=$c->id)
                                    <a href="{{url('summary')}}/?id_credit={{$c->id}}" class="btn btn-info">{{$c->id}}</a>
                                @endif
                            @endforeach
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
