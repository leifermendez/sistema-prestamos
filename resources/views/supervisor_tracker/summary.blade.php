@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Ventas realizadas</h4>
                            <table class="table supervisor-ventas-table">
                                <tbody>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Credito</th>
                                    <th>Barrio</th>
                                    <th>Hora</th>
                                    <th>Tasa</th>
                                    <th>Cuotas</th>
                                    <th>Valor neto</th>
                                </tr>
                                @foreach($credit as $cred)
                                    <tr>
                                        <td><span class="value">{{$cred->name}} {{$cred->last_name}}</span></td>
                                        <td><span class="value">{{$cred->credit_id}}</span></td>
                                        <td><span class="value">{{$cred->province}}</span></td>
                                        <td><span class="value">{{$cred->created_at}}</span></td>
                                        <td><span class="value">{{$cred->utility}}</span></td>
                                        <td><span class="value">{{$cred->payment_number}}</span></td>
                                        <td><span class="value">{{$cred->amount_neto}}</span></td>

                                    </tr>
                                @endforeach

                                </tbody></table>
                            <footer class="widget-footer">
                                <p><b>Total: </b><span class="text-success">{{$total_credit}}</span></p>
                            </footer>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Pagos Recibidos</h4>
                            <table class="table supervisor-pagos-table">
                                <tbody>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Credito</th>
                                    <th>Cuota</th>
                                    <th>Valor</th>
                                    <th>Hora</th>
                                </tr>
                                @foreach($summary as $sum)
                                    <tr>
                                        <td><span class="value">{{$sum->name}} {{$sum->last_name}}</span></td>
                                        <td><span class="value">{{$sum->id_credit}}</span></td>
                                        <td><span class="value">{{$sum->number_index}}</span></td>
                                        <td><span class="value">{{$sum->amount}}</span></td>
                                        <td><span class="value">{{($sum->created_at)}}</span></td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                            <footer class="widget-footer">
                                <p><b>Total: </b><span class="text-success">{{$total_summary}}</span></p>
                            </footer>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
