@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">

                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Consulta de Gastos</h4>
                            <form class="form-inline" method="GET" {{url('supervisor/bill')}}>
                                <div class="form-group">
                                    <label for="email">Feacha Inicio:</label>
                                    <input type="text" required class="form-control datepicker-trigger" name="date_start" id="date_start">
                                </div>

                                <div class="form-group">
                                    <label for="pwd">Fecha Final:</label>
                                    <input type="text" required class="form-control datepicker-trigger" name="date_end" id="pwd">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Categoria:</label>
                                    <select name="category" required id="" class="form-control">
                                        @foreach($list_categories  as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                            <option value="">Todos</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Buscar</button>
                            </form>
                            <br class="clearfix">
                            <table class="table supervisor-billS-table">
                                <tbody>
                                <tr class="visible-lg">
                                    <th>Fecha</th>
                                    <th>Cartera</th>
                                    <th>Valor</th>
                                    <th>Detalle</th>
                                    <th>Categoría</th>
                                    <th>Agente</th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->created_at}}</td>
                                        <td>{{$client->wallet_name}}</td>

                                        <td>{{$client->amount}}</td>
                                        <td>{{$client->description}}</td>
                                        <td>{{$client->category_name}}</td>
                                        <td>{{$client->user_name}}</td>
                                    </tr>
                                @endforeach

                                </tbody></table>
                            <footer class="widget-footer">
                                <p><b>Total: </b><span class="text-success">{{$sum}}</span></p>
                            </footer>
                        </div><!-- .widget -->

                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
