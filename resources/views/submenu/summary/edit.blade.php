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
                                <h4 class="widget-title">Editar pago</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('supervisor/summary')}}/{{$id_summary}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group">
                                        <label for="name">Nombres:</label>
                                        <input type="text" name="name" value ="{{$name}} {{$last_name}}" readonly class="form-control" id="name">
                                        <input type="hidden" name="id_wallet" value="{{$id_wallet}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Barrio:</label>
                                        <input type="text" name="credit_id" value="{{$province}}" readonly class="form-control" id="address">
                                    </div>
                                    <div class="form-group">
                                        <label for="province">Credito:</label>
                                        <input type="text" name="province" value="{{$credit_id}}" readonly class="form-control" id="province">
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Valor:</label>
                                        <input type="text" name="amount" value="{{$amount_value}}" class="form-control" id="amount">
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
