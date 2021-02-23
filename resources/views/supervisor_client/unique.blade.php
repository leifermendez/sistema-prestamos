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
                                <h4 class="widget-title">Informacion de cliente</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('supervisor/client')}}/{{$user->id}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group">
                                        <label for="nit_number">Nº Identificacion:</label>
                                        <input type="text" name="nit_number" value="{{isset($user) ? $user->nit : ''}}" class="form-control" id="nit_number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nombres:</label>
                                        <input type="text" name="name"  value="{{isset($user) ? $user->name : ''}}"  class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Apellidos:</label>
                                        <input type="text" name="last_name" value="{{isset($user) ? $user->last_name : ''}}"  class="form-control" id="last_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Direccion:</label>
                                        <input type="text" name="address"  value="{{isset($user) ? $user->address : ''}}"  class="form-control" id="address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="province">Barrio:</label>
                                        <input type="text" name="province"  value="{{isset($user) ? $user->province : ''}}"  class="form-control" id="province" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Teléfono:</label>
                                        <input type="tel" name="phone"  value="{{isset($user) ? $user->phone : ''}}"  class="form-control" id="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <select name="status" class="form-control" id="">
                                            <option {{($user->status == 'good') ? 'selected' : ''}} value="good">Bueno</option>
                                            <option {{($user->status == 'bad') ? 'selected' : ''}}  value="bad">Malo</option>
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
