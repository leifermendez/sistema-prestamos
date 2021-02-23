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
                                <h4 class="widget-title">Editar Gastos</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('supervisor/bill/')}}/{{$id}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="id_wallet" value="{{ app('request')->input('id_wallet') }}">
                                    <div class="form-group">
                                        <label for="type">Gasto:</label>
                                        <input type="text" name="type" value="{{$type}}"  class="form-control" id="type" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Detalle:</label>
                                        <input type="text" name="description" value="{{$description}}"  class="form-control" id="description" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Valor:</label>
                                        <input type="number" name="amount" value="{{$amount}}"  class="form-control" id="amount" required>
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
