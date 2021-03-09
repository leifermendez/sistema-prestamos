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
                                <h4 class="widget-title">Asignar Base</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('supervisor/agent')}}/{{$id}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group">
                                        <label for="name">Nombres:</label>
                                        <input type="text" name="name" value="{{$name}} {{$last_name}}" class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Cartera:</label>
                                        <input type="text" name="name" value="{{$wallet_name}}" class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_number_current">Base actual:</label>
                                        <input type="number" name="base_number_current" value="{{$base_current}}"  readonly class="form-control" id="base_number_current" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="base_number">Base:</label>
                                        <input type="number" name="base_number" class="form-control" id="base_number" required>
                                        <p class="text-muted">La nueva base se sumara con la base actual</p>
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
