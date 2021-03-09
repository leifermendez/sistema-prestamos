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
                                    @if($client->active_user=='enabled')
                                        <tr>
                                            <td>{{$client->id}}</td>
                                            <td>{{$client->email}}</td>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->level}}</td>
                                            <td>{{$client->wallet_name}}</td>
                                            <td>{{$client->supervisor}}</td>
                                            <td>
                                                <form action="{{url('admin/user')}}/{{$client->id}}" method="POST"
                                                      class="pull-left px-1">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-xs">Eliminar
                                                    </button>
                                                </form>



                                                <a href="{{url('admin/user')}}/{{$client->id}}/edit"
                                                   class="btn btn-info btn-xs px-1">Editar</a>
                                                @if($client->level == 'supervisor')
                                                    <a href="{{url('admin/user')}}/{{$client->id}}"
                                                       class="btn btn-warning btn-xs">Asignar agente</a>
                                                @endif

                                                <form action="{{url('admin/session')}}/{{$client->id}}" method="POST"
                                                      class="pull-left px-1">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" class="btn btn-inverse btn-xs">Session
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>
                            </table>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
