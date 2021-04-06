@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Movimientos desde {{$date_start}} hasta {{$date_end}}</h4>
                            <table class="table supervisor-done-table">
                                <tbody>
                                <tr class="visible-lg">
                                    <th>ID Credito</th>
                                    <th>Nombre</th>
                                    <th>Fecha Prestamo</th>
                                    <th>Capital</th>
                                    <th>Tasa</th>
                                    <th>Interes</th>
                                    <th>Cuotas</th>
                                    <th>Ultimo Pago</th>
                                    <th>Valor Pago</th>
                                    <th># Pagos</th>

                                </tr>
                                @foreach($credit as $cred)
                                    <tr>
                                        <td><span class="value">{{$cred->credit_id}}</span></td>
                                        <td><span class="value">{{$cred->name}} {{$cred->last_name}}</span></td>
                                        <td><span class="value">{{$cred->credit_date}}</span></td>
                                        <td><span class="value">{{$cred->amount_neto}}</span></td>
                                        <td><span class="value">{{$cred->utility}}</span></td>
                                        <td><span class="value">{{($cred->amount_neto)*($cred->utility)}}</span></td>
                                        <td><span class="value">{{$cred->payment_number}}</span></td>
                                        <td><span class="value">{{$cred->summary_lasted}}</span></td>
                                        <td><span class="value">{{$cred->summary_amount}}</span></td>
                                        <td><span class="value">{{$cred->summary_number_pay}}</span></td>


                                    </tr>
                                @endforeach

                                </tbody></table>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
                <div class="col-lg-12 text-right">
                    <a href="{{url('supervisor/review/')}}/{{$id_wallet}}" class="btn btn-inverse"><i class="fa fa-arrow-left"></i> Regresar</a>
                </div>
            </section>
        </div>
    </main>
@endsection
