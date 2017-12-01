@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Usuarios</h4>
                            <table class="table admin-table">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Nivel</th>
                                    <th>Cartera</th>
                                    <th>Supervisor</th>
                                    <th></th>
                                </tr>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->email}}</td>
                                        <td>{{$client->name}}</td>
                                        <td>{{$client->level}}</td>
                                        <td>{{$client->wallet_name}}</td>
                                        <td>{{$client->supervisor}}</td>
                                        <td>
                                            <a href="{{url('admin/user')}}/{{$client->id}}/edit" class="btn btn-info btn-xs">Editar</a>
                                            @if($client->level == 'supervisor')
                                                <a href="{{url('admin/user')}}/{{$client->id}}" class="btn btn-warning btn-xs">Asignar agente</a>
                                            @endif
                                        </td>
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
