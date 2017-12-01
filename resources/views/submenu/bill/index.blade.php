@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Gastos</h4>
                            <form class="form-inline" action="{{url('supervisor/menu/bill')}}/{{$id}}" method="GET">
                                <div class="form-group">
                                    <label for="nit_number"> Fecha Inicial:</label>
                                    <input type="text" name="date_start"  class="form-control datepicker-trigger" id="date_start" required>
                                </div>
                                <div class="form-group">
                                    <label for="nit_number"> Fecha Final:</label>
                                    <input type="text" name="date_end"  class="form-control datepicker-trigger" id="date_end" required>
                                </div>

                                <button class="btn btn-info" type="submit">Buscar</button>

                            </form>
                            <br class="clearfix">
                            <table class="table supervisor-gastos-table">
                                <tbody>
                                <tr>
                                    <th>Cartera</th>
                                    <th>Fecha</th>
                                    <th>Agente</th>
                                    <th>Gasto</th>
                                    <th>Valor</th>
                                    <th>Detalle</th>
                                    <th></th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->wallet_name}}</td>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->user_name}} {{$client->user_lastname}}</td>
                                        <td>{{$client->type}}</td>
                                        <td>{{$client->amount}}</td>
                                        <td>{{$client->description}}</td>
                                        <td></td>
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
