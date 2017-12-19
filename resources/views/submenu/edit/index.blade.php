@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Creditos Otorgados</h4>
                            <table class="table supervisor-editC-table">
                                <thead>
                                <tr class="visible-lg">
                                    <th>Nombres</th>
                                    <th>Credito</th>
                                    <th>Barrio</th>
                                    <th>Hora</th>
                                    <th>Tasa</th>
                                    <th>Cuotas</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($credit as $cred)
                                    <tr>
                                        <td><span class="value">{{$cred->name}} {{$cred->last_name}}</span></td>
                                        <td><span class="value">{{$cred->credit_id}}</span></td>
                                        <td><span class="value">{{$cred->province}}</span></td>
                                        <td><span class="value">{{$cred->created_at}}</span></td>
                                        <td><span class="value">{{$cred->utility}}</span></td>
                                        <td><span class="value">{{$cred->payment_number}}</span></td>
                                        <td><span class="value">{{($cred->amount_neto)+($cred->amount_neto*$cred->utility)}}</span></td>
                                        <td class="text-right">
                                            <form action="{{url('supervisor/credit')}}/{{$cred->credit_id}}?date_start={{$date_start}}&id_wallet={{$id_wallet}}" method="POST">
                                                <a href="{{url('supervisor/credit')}}/{{$cred->credit_id}}/edit?id_wallet={{$id_wallet}}" class="btn btn-xs btn-warning">Editar</a>
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-xs btn-danger" type="submit">Eliminar</button>
                                            </form>

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody></table>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Gastos del Agente</h4>
                            <table class="table supervisor-editG-table">
                                <thead>
                                <tr class="visible-lg">
                                    <th>Gasto</th>
                                    <th>Detalle</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($bills as $bill)
                                    <tr>
                                        <td><span class="value">{{$bill->type}}</span></td>
                                        <td><span class="value">{{$bill->description}}</span></td>
                                        <td><span class="value">{{$bill->amount}}</span></td>
                                        <td class="text-right">
                                            <form action="{{url('supervisor/bill')}}/{{$bill->id}}?date_start={{$date_start}}&id_wallet={{$id_wallet}}" method="POST">
                                                <a href="{{url('supervisor/bill')}}/{{$bill->id}}/edit?id_wallet={{$id_wallet}}" class="btn btn-xs btn-warning">Editar</a>
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-xs btn-danger" type="submit">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Pagos Recibidos</h4>
                            <table class="table supervisor-editP-table">
                                <thead>
                                <tr class="visible-lg">
                                    <th>Nombres</th>
                                    <th>Credito</th>
                                    <th>Cuota</th>
                                    <th>Valor</th>
                                    <th>Saldo</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($summary as $sum)
                                    <tr>
                                        <td><span class="value">{{$sum->name}} {{$sum->last_name}}</span></td>
                                        <td><span class="value">{{$sum->credit_id}}</span></td>
                                        <td><span class="value">{{$sum->number_index}}</span></td>
                                        <td><span class="value">{{$sum->amount}}</span></td>
                                        <td><span class="value">{{(($sum->amount_neto)+($sum->amount_neto*$sum->utility))-($sum->total_payment)}}</span></td>
                                        <td class="text-right">

                                            <form action="{{url('supervisor/summary')}}/{{$sum->id_summary}}?date_start={{$date_start}}" method="POST">
                                                <a href="{{url('supervisor/summary')}}/{{$sum->id_summary}}/edit?id_wallet={{$id_wallet}}" class="btn btn-xs btn-warning">Editar</a>
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-xs btn-danger" type="submit">Eliminar</button>
                                            </form>

                                        </td>
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
