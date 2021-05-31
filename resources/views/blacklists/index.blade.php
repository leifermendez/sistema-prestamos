@extends('layouts.app')

@section('content')

    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg overflow-auto">
                            <h4 class="m-b-lg">Lista de Clavos</h4>

                            <div class="d-none d-lg-block d-xl-block">
                                <table class="table agente-blacklists-table">
                                <thead>
                                <tr>
                                    <th>#Credito</th>
                                    <th>Fecha de Ingreso</th>
                                    <th>Nombres</th>
                                    <th>Pagar</th>

                                </tr>
                                </thead>

                                <tbody>
                                @foreach($clients as $client)

                                    <tr id="td_{{$client->id}}">
                                        <td>{{$client->id_credit}}</td>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->user_name}} {{$client->user_last_name}}</td>
                                        <td><a href="{{url('payment')}}/{{$client->id_credit}}?rev=true" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Pagar</a></td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            </div>

{{--                            MOBILE--}}
                            <div class="d-sm-block d-lg-none">
                                <table class="table agente-blacklists-table">
                                <thead class="d-none">
                                <tr>
                                    <th>#Credito</th>
                                    <th>Fecha de Ingreso</th>
                                    <th>Nombres</th>
                                    <th>Pagar</th>

                                </tr>
                                </thead>

                                <tbody>
                                @foreach($clients as $client)

                                    <tr id="td_{{$client->id}}">
                                        <td>{{$client->id_credit}}</td>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->user_name}} {{$client->user_last_name}}</td>
                                        <td><a href="{{url('payment')}}/{{$client->id_credit}}?rev=true" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Pagar</a></td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            </div>

                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection