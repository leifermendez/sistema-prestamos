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
                                <h4 class="widget-title">Editar usuario</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('admin/user')}}/{{$user->id}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="form-group">
                                        <input type="hidden" name="act" value="assign">
                                        <input type="text" class="form-control" value="{{$user->name}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Agente:</label>
                                        <select name="id_agent"  class="form-control" id="country">
                                            @foreach($agents as $agent)
                                                @if(!$agent->ocuped)
                                                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Cartera:</label>
                                        <select name="id_wallet"  class="form-control" id="country">
                                            @foreach($wallets as $agent)
                                                @if(!$agent->ocuped)
                                                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                                                @endif
                                            @endforeach

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
