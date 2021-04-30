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
                        <button class="btn btn-primary float-left" id="changeList">Ordenar lista</button>
                        <button class="btn btn-primary float-left d-none  mb-4" id="seeList">Ver lista</button>
                        @if(app('request')->input('hide'))
                        <div class="alert alert-warning alert-custom alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h4 class="alert-title">Informacion</h4>
                            <p>Orden cambiado por encima/debajo de un usuario que saltaste el dia de hoy.</p>
                        </div>
                        @endif

                        <table class="table agente-route-table">
                            <thead>
                                <tr>
                                    <th class="hidden">Orden</th>
                                    <th># Credito</th>
                                    <th>Nombres</th>
                                    <th>Cuotas Atrasadas</th>
                                    <th>Cuota diaria</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                    <th>Ultimo pago</th>
                                    <th>Tipo de Negocio</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="connectedSortable" id="complete-item-drop">
                                @foreach($clients as $client)
                                <tr id="td_{{$client->id}}" class="item" item-id="{{$client->id }}">
                                    <td class="hidden">{{$client->order_list}}</td>
                                    <td>{{$client->id}}</td>
                                    <td>{{$client->user->name}} {{$client->user->last_name}}</td>
                                    <td>{{$client->days_rest}}</td>
                                    <td>{{$client->quote}}</td>
                                    <td>{{$client->amount_total}}</td>
                                    <td id="saldo">{{$client->saldo}}</td>
                                    @if($client->last_pay)
                                    <td>{{$client->last_pay->created_at}}</td>
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
                                        <a href="{{url('route')}}/{{$client->order_list}}/edit?id_credit={{$client->id}}&direction=up"
                                            class="btn btn-default btn-xs arw-up btn-center-arrow"><i
                                                class="fa fa-arrow-up"></i></a>
                                        <a href="{{url('payment')}}/{{$client->id}}"
                                            class="btn btn-success btn-xs hidden"><i class="fa fa-money"></i> Pagar</a>

                                        <a href="#openModal{{$client->id}}" class="btn btn-success btn-xs"> Pagar</a>

                                        @include('route.modal')

                                        <a href="{{url('route')}}/" id_user="{{$client->id_user}}"
                                            id_credit="{{$client->id}}"
                                            class="btn btn-warning btn-xs ajax-btn btn-pagar"><i
                                                class="fa fa-archive "></i> Saltar</a>
                                        <form action="{{url('pending-pay')}}" method="POST" class="pull-left px-1">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id_credit" value="{{$client->id}}">
                                            <button type="submit" class="btn btn-inverse btn-xs">
                                                Pendiente
                                            </button>
                                        </form>
                                        <a href="{{url('summary')}}?id_credit={{$client->id}}"
                                            class="btn btn-info btn-xs hidden"><i class="fa fa-history"></i> Ver</a>
                                        <a href="{{url('route')}}/{{$client->order_list}}/edit?id_credit={{$client->id}}&direction=down"
                                            class="btn btn-default btn-xs arw-down btn-center-arrow"><i
                                                class="fa fa-arrow-down"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table agente-route-table" id="pending">
                            <thead>
                                <tr>
                                    <th># Credito</th>
                                    <th>Nombres</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($pending as $client)
                                <tr id="td_{{$client->id}}">
                                    <td>{{$client->id}}</td>
                                    <td>{{$client->id}}</td>
                                    <td>{{$client->id}}</td>
                                    <td>{{$client->user_name}} {{$client->user_last_name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div><!-- .widget -->
                </div>
            </div><!-- .row -->
        </section>
    </div>
</main>
@endsection