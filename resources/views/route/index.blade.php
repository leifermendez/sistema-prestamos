@extends('layouts.app')

@section('content')
    <!-- MODAL ========-->
    <!-- Modal -->
    <div id="modal_pay" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form class="modal-pay" action="{{url('summary')}}" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Abono de cuota</h4>
                    </div>
                    <div class="modal-body main-body">
                        <div class="form-group">
                            <label for="name">Nombres:</label>
                            <input type="text" readonly class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="credit_id">Número de credito:</label>
                            <input type="text" readonly class="form-control" id="credit_id">
                        </div>
                        <div class="form-group">
                            <label for="amount_value">Valor de venta:</label>
                            <input type="text" readonly class="form-control" id="amount_value">
                        </div>
                        <div class="form-group">
                            <label for="done">Pagado:</label>
                            <input type="text" readonly class="form-control" id="done">
                        </div>
                        <div class="form-group">
                            <label for="saldo">Saldo:</label>
                            <input type="text" readonly class="form-control" id="saldo">
                        </div>
                        <div class="form-group">
                            <label for="payment_number">Valor de cuota:</label>
                            <input type="text" readonly class="form-control" id="payment_quote">
                        </div>
                        <div class="form-group">
                            <label for="done_payment">Cuotas pagadas:</label>
                            <input type="text" readonly class="form-control" id="done_payment">
                        </div>
                        <div class="form-group">
                            <label for="amount">Valor de abono:</label>
                            <input type="number" step="any" min="1" max="" required name="amount" class="form-control" id="amount">
                        </div>
                    </div>
                    <div class="modal-body msg-success hidden">
                        <div class="form-group text-center">
                            <small class="text-color">Pago realizado</small>
                            <h2 class="text-success">0</h2>
                            <small class="text-color">Saldo</small>
                            <h2 class="text-primary">0</h2>
                        </div>
                    </div>
                    <div class="modal-footer main-body">
                        <button type="submit"  class="btn btn-success btn-block btn-md">Guardar pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FIN MODAL ========-->
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Clientes y Creditos</h4>
                            @if(app('request')->input('hide'))
                                <div class="alert alert-warning alert-custom alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="alert-title">Informacion</h4>
                                    <p>Orden cambiado por encima/debajo de un usuario que saltaste el dia de hoy.</p>
                                </div>
                            @endif

                            <table class="table agente-route-table">
                                <thead>
                                <tr>
                                    <th class="hidden">Orden</th>
                                    <th>Credito</th>
                                    <th>Nombres</th>
                                    <th>Días en mora</th>
                                    <th>Cuota diaria</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                    <th>Ultimo pago</th>
                                    <th>Barrio</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($clients as $client)

                                    <tr id="td_{{$client->id}}">
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
                                            <a href="{{url('route')}}/{{$client->order_list}}/edit?id_credit={{$client->id}}&direction=up" class="btn btn-default btn-xs arw-up btn-center-arrow"><i class="fa fa-arrow-up"></i></a>
                                            <a href="{{url('payment')}}/{{$client->id}}" class="btn btn-success btn-xs hidden"><i class="fa fa-money"></i> Pagar</a>
                                            <button type="button" class="btn btn-success btn-xs btn-pagar" data-toggle="modal" data-id="{{$client->id}}" data-target="#modal_pay">Pagar</button>
                                            <a href="javascript:void(0)" id_user="{{$client->id_user}}" id_credit="{{$client->id}}" class="btn btn-warning btn-xs ajax-btn btn-pagar"><i class="fa fa-archive "></i> Saltar</a>
                                            <a href="{{url('summary')}}?id_credit={{$client->id}}" class="btn btn-info btn-xs hidden"><i class="fa fa-history"></i> Ver</a>
                                            <a href="{{url('route')}}/{{$client->order_list}}/edit?id_credit={{$client->id}}&direction=down" class="btn btn-default btn-xs arw-down btn-center-arrow"><i class="fa fa-arrow-down"></i></a>
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
