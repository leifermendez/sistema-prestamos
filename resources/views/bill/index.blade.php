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
                            <form class="form-inline" action="{{url('bill')}}" method="GET">
                                <div class="form-group hidden">
                                    <label for="nit_number"> Fecha Inicial:</label>
                                    <input type="text" name="date_start"  class="form-control datepicker-trigger" id="date_start" required>
                                </div>
                                <div class="form-group hidden">
                                    <label for="nit_number"> Fecha Final:</label>
                                    <input type="text" name="date_end"  class="form-control datepicker-trigger" id="date_end" required>
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
                                 <button class="btn btn-info hidden" type="submit">Buscar</button>
                                <a href="{{url('bill/create')}}" class="btn btn-success">Agregar</a>

                            </form>
                            <br class="clearfix">

                            <div class=" d-none d-lg-block d-xl-block overflow-auto">
                                <table class="table agente-g-table">
                                    <tbody>
                                            <tr>
                                                <th>Cartera</th>
                                                <th>Fecha</th>
                                                <th>Valor</th>
                                                <th>Detalle</th>
                                                <th>Categoría</th>
                                                <th>Cobrador</th>
                                                <th></th>
                                            </tr>
                                    
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{$client->wallet_name}}</td>
                                            <td>{{$client->created_at}}</td>

                                            <td>{{$client->amount}}</td>
                                            <td>{{$client->description}}</td>
                                            <td>{{$client->category_name}}</td>
                                            <td>{{$client->user_name}}</td>

                                            <td></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <!-- FOR MOBILE -->
                            <div class="d-sm-block d-lg-none">
                                <table class="table agente-g-table">
                                    <tbody>
                                            <!-- <tr>
                                                <th>Cartera</th>
                                                <th>Fecha</th>
                                                <th>Valor</th>
                                                <th>Detalle</th>
                                                <th>Categoría</th>
                                                <th>Cobrador</th>
                                                <th></th>
                                            </tr> -->
                                    
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{$client->wallet_name}}</td>
                                            <td>{{$client->created_at}}</td>

                                            <td>{{$client->amount}}</td>
                                            <td>{{$client->description}}</td>
                                            <td>{{$client->category_name}}</td>
                                            <td>{{$client->user_name}}</td>

                                            <td></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            
                            <footer class="widget-footer">
                                <p><b>Total: </b><span class="text-success">{{$total}}</span></p>
                            </footer>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
