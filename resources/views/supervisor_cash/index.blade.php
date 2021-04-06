@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">

                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Cartera</h4>
                            <table class="table supervisor-cash-table">
                                <tbody>
                                <tr class="visible-lg">
                                    <th>Cartera</th>
                                    <th>Detalle</th>
                                    <th>Valor inicial</th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->name}}</td>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->base}}</td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                            <footer class="widget-footer">
                                <p class="text-success"><b>Total: </b> {{$sum}}</p>
                            </footer>
                        </div><!-- .widget -->

                    </div>
                </div><!-- .row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Historial Caja</h4>
                            <table class="table client-table">
                                <tbody>
                                <tr class="visible-lg">
                                    <th>Fecha</th>
                                    <th>Saldo Base</th>
                                </tr>
                                @foreach($report as $r)
                                    <tr>
                                        <td>{{$r->created_at}}</td>
                                        <td>{{$r->total}}</td>
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
