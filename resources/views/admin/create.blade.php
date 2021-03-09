@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12 col-lg-8 offset-lg-2">
                        <div class="widget">
                            <header class="widget-header">
                                <h4 class="widget-title">Agregar usuario</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('admin/user')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input type="text" name="username"   class="form-control" id="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nombre:</label>
                                        <input type="text" name="name"  class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Contraseña:</label>
                                        <input type="password" name="pwd"   class="form-control" id="pwd" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="level">Nivel:</label>
                                        <select name="level"  class="form-control" id="level">
                                            <option value="agent">Agente</option>
                                            <option value="supervisor">Supervisor</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block btn-md">Guardar</button>
                                    </div>
                                </form>

                            </div><!-- .widget-body -->
                        </div><!-- .widget -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
