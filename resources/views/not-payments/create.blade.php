@extends('layouts.app')

@section('content')
<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">
            <div class="row">
                <div class="col-md-12 col-lg-8 offset-lg-2">
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <div class="widget">
                        <header class="widget-header">
                            <h4 class="widget-title">Clientes que no pagaron por días</h4>
                        </header><!-- .widget-header -->
                        <hr class="widget-separator">
                        <div class="widget-body">
                            <form method="POST" action="{{ url('not-pay') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="nit_number"> Fecha inicial:</label>
                                    <input type="text" name="date_start" class="form-control datepicker-trigger"
                                        id="date_start" required>
                                </div>
                                <div class="form-group">
                                    <label for="nit_number"> Fecha final:</label>
                                    <input type="text" name="date_end" class="form-control datepicker-trigger"
                                        id="date_end" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block btn-md">Buscar</button>
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