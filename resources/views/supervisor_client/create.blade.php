@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12 col-lg-8 offset-lg-2">
                        <div class="widget">
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('supervisor/client')}}" class="supervisor-client" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="country"> Pais:</label>
                                        <select name="country" class="form-control" id="country">
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="wallet"> Cartera:</label>
                                        <select name="wallet" class="form-control" id="wallet">
                                            <option selected>Selecionar ....</option>
                                            @foreach($wallet as $w)
                                                <option value="{{$w->id}}">{{$w->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="agent"> Agente:</label>
                                        <select name="agent" class="form-control" id="agent">
                                            @foreach($agents as $a)
                                                <option value="{{$a->id}}">{{$a->name}} {{$a->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="hidden btn btn-success btn-block btn-md">Guardar</button>
                                        <a id="link_client_audit" class="btn btn-success btn-block" disabled href="{{url('supervisor/client')}}">Auditar</a>
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
