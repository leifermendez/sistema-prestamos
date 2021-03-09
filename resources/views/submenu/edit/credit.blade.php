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
                                <h4 class="widget-title">Editar Credito</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('supervisor/credit/')}}/{{$id}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="id_wallet" value="{{ app('request')->input('id_wallet') }}">
                                    <div class="form-group">
                                        <label for="name">Nombres:</label>
                                        <input type="text" name="name" readonly  value="{{$name}}"  class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Apellidos:</label>
                                        <input type="text" name="last_name" readonly value="{{$last_name}}"  class="form-control" id="last_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="province">Barrio:</label>
                                        <input type="text" name="province" readonly  value="{{$province}}"  class="form-control" id="province" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Teléfono:</label>
                                        <input type="tel" name="phone" readonly  value="{{$phone}}"  class="form-control" id="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <select name="status" class="form-control" disabled id="">
                                            <option {{($status == 'good') ? 'selected' : ''}} value="good">Bueno</option>
                                            <option {{($status == 'bad') ? 'selected' : ''}}  value="bad">Malo</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount_neto">Valor:</label>
                                        <input type="tel" name="amount_neto"  value="{{$amount_neto}}"  class="form-control" id="amount_neto" required>
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
