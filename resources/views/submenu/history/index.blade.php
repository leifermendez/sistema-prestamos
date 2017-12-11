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
                            <table class="table supervisor-history-table">

                                <thead>
                                <tr class="visible-lg">
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
                                    <tr>
                                        <td><span class="value">{{$client->name}} {{$client->last_name}}</span></td>
                                        <td><span class="value">{{$client->credit_id}}</span></td>
                                        <td><span class="value">{{$client->amount_neto}}</span></td>
                                        <td><span class="value">{{($client->summary_total)}}</span></td>
                                        <td><span class="value">{{$client->number_index}}/{{$client->payment_number}}</span></td>
                                        <td>
                                            <a href="{{url('supervisor/menu/history')}}/{{$client->credit_id}}" class="btn btn-info btn-xs">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                                <footer class="widget-footer">
                                    <p><b>Falta cobrar </b> <span class="text-primary">{{$total_rest}}</span> de <span class="text-success">{{$total_credit}}</span></p>
                                </footer>
                        </div><!-- .widget -->
                        <div class="col-lg-12 text-right">
                            <a href="{{url('supervisor/review/')}}/{{$id_wallet}}" class="btn btn-inverse"><i class="fa fa-arrow-left"></i> Regresar</a>
                        </div>
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
