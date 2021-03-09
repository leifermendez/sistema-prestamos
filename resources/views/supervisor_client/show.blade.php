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
                                <form method="POST" action="{{url('bill')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="type_bill"> Tipo de gasto:</label>
                                        <select name="type_bill" class="form-control" id="type_bill">
                                            <option value="gasolina">Gasolina</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount"> Valor:</label>
                                        <input type="text" name="amount"  class="form-control" id="amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Detalle</label>
                                        <textarea name="description" id="description" class="form-control" id="" maxlength="100" cols="30" rows="4"></textarea>
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
