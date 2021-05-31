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

                            <div class="d-none d-lg-block d-xl-block">
                                <table class="table supervisor-history-table">

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
                                </tbody>
                            </table>
                            </div>

{{--                            MOBILE--}}
                            <div class="d-sm-block d-lg-none">
                                <table class="table supervisor-history-table">

                                    <thead class="d-none">
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
                                    </tbody>
                                </table>
                            </div>

                            <div class="w-100 mx-auto mt-4 alert alert-success d-flex justify-content-between"> 
                               <b> <p class="m-0">CARTERA TOTAL = ${{$total_rest}} </p> </b>
                                <h5 class="m-0"></h5>
                            </div>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection