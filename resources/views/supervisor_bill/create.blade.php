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
                                <h4 class="widget-title">Ingresar gastos</h4>
                            </header><!-- .widget-header -->
                            <hr class="widget-separator">
                            <div class="widget-body">
                                <form method="POST" action="{{url('supervisor/bill')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="name">Cartera:</label>
                                        <select name="id_wallet" id="" required class="form-control">
                                            @foreach($wallet as $w)
                                                <option value="{{$w->id}}">{{$w->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tipo de gasto:</label>
                                        <select name="bill" id="" required class="form-control">
                                            @foreach($list_bill as $l)
                                                <option value="{{$l->id}}">{{$l->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Valor</label>
                                        <input type="number" class="form-control" required id="amount" name="amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Detalle</label>
                                        <textarea name="description" class="form-control" required id="" cols="30" maxlength="100" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block btn-md">Guardar</button>
                                        <a href="{{url('supervisor/bill/')}}" class="btn btn-info btn-block btn-md">Consultar</a>
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
