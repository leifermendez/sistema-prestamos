@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">

                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Caja Actual</h4>
                            <div class="d-none d-lg-block d-xl-block overflow-auto">
                                <table class="table supervisor-cash-table">
                                    <tbody>
                                            <tr>
                                                <th>Cobro</th>
                                                <th>Detalle</th>
                                                <th>Caja Actual Cierre</th>
                                            </tr> 
                                    
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->created_at}}</td>
                                            <td>{{$client->base}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <!-- FOR MOBILE -->
                            <div class="d-sm-block d-lg-none">
                                <table class="table supervisor-cash-table">
                                    <tbody>
                                            <!-- <tr>
                                                <th>Cartera</th>
                                                <th>Detalle</th>
                                                <th>Valor inicial</th>
                                            </tr>  -->
                                    
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->created_at}}</td>
                                            <td>{{$client->base}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
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
                            <div class="d-none d-lg-block d-xl-block overflow-auto">
                                <table class="table client-table">
                                    <tbody>
                                            <tr>
                                                <th>Fecha Año/Mes/Dia </th>
                                                <th>Cobro</th>
                                                <th>Caja</th>
                                            </tr>  
                                    
                                    @foreach($report as $r)
                                        <tr>
                                            <td>{{$r->created_at}}</td>
                                            <td>{{$r->wallet_name}}</td>
                                            <td>{{$r->total}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>   
                            </div>

                            <!-- FOR MOBILE -->
                            <div class="d-sm-block d-lg-none">
                                <table class="table client-table">
                                    <tbody>
                                            <!-- <tr>
                                                <th>Fecha</th>
                                                <th>Saldo Base</th>
                                            </tr>   -->
                                    
                                    @foreach($report as $r)
                                        <tr>
                                            <td>{{$r->created_at}}</td>
                                            <td>{{$r->total}}</td>
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
