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
                            <table class="table agente-payments-table">
                                <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Credito</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                    <th>Cuota</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($clients as $client)
                                    @if($client->positive>0)
                                    <tr id="credit_{{$client->credit_id}}">
                                        <td>{{$client->name}} {{$client->last_name}}</td>
                                        <td>{{$client->credit_id}}</td>
                                        <td>{{$client->amount_neto}}</td>
                                        <td id="saldo">{{$client->positive}}</td>
                                        <td>{{$client->payment_current}} / {{$client->payment_number}}</td>
                                        <td>
                                            <!-- Trigger the modal with a button -->



                                            <a href="{{url('payment')}}/{{$client->credit_id}}?rev=true" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Pagar</a>
                                            <a href="{{url('summary')}}?id_credit={{$client->credit_id}}" class="btn btn-info btn-xs"><i class="fa fa-history"></i> Ver</a>
                                        </td>
                                    </tr>
                                    @endif

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
