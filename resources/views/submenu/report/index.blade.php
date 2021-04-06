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
                            <table class="table supervisor-report-table">
                                <tbody>
                                <tr class="visible-lg">
                                    <th>Fecha cierre</th>
                                    <th>Base</th>
                                    <th>Recaudo</th>
                                    <th>Creditos</th>
                                    <th>Gasto Agente</th>
                                    <th>Cierre</th>
                                    <th>Gasto Supervisor</th>
                                    <th>Valor Cartera</th>

                                </tr>
                                @foreach($credit as $cred)
                                    <tr>
                                        <td><span class="value">{{$cred->created_at}}</span></td>
                                        <td><span class="value">{{$cred->base_before}}</span></td>
                                        <td><span class="value">{{$cred->summary_total}}</span></td>
                                        <td><span class="value">{{$cred->credit_total}}</span></td>
                                        <td><span class="value">{{$cred->bills_total}}</span></td>
                                        <td><span class="value">{{$cred->total_day}}</span></td>
                                        <td><span class="value">{{$cred->supervisor_bills}}</span></td>
                                        <td><span class="value">{{$cred->base_wallet}}</span></td>


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
