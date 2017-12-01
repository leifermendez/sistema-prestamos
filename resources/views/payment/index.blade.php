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
                            <table class="table agente-payments-table">
                                <tbody>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Credito</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                    <th>Cuota</th>
                                    <th></th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->name}} {{$client->last_name}}</td>
                                        <td>{{$client->credit_id}}</td>
                                        <td>{{$client->amount_neto}}</td>
                                        <td>{{$client->positive}}</td>
                                        <td>{{$client->payment_current}} / {{$client->payment_number}}</td>
                                        <td>
                                            <a href="{{url('payment')}}/{{$client->credit_id}}" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Pagar</a>
                                            <a href="{{url('summary')}}?id_credit={{$client->credit_id}}" class="btn btn-info btn-xs"><i class="fa fa-history"></i> Ver</a>
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
