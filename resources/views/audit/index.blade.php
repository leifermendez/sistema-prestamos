@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Movimiento del personal</h4>
                            <form action="{{url('admin/audit')}}" method="GET">
                                <div class="d-flex justify-content-around align-items-center">
                                    <div>
                                        <label for="nit_number"> Fecha Inicial:</label>
                                        <input type="text" name="date_start"  class="form-control datepicker-trigger" id="date_start" required>
                                    </div>
                                    <div>
                                        <label for="nit_number"> Fecha Final:</label>
                                        <input type="text" name="date_end"  class="form-control datepicker-trigger" id="date_end" required>
                                    </div>

                                    <button class="btn btn-info hidden" type="submit">Buscar</button>
                                </div>
                            </form>
                            <br class="clearfix">
                            <div class="container">
                                @foreach($audits as $audit)
                                    <div class="card shadow mt-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>{{$audit->user_name}} {{$audit->user_last_name}}
                                                        &nbsp;&nbsp;||&nbsp;&nbsp;
                                                        @if($audit->event === 'create')
                                                            Creó: {{$audit->type}}
                                                        @endif

                                                        @if($audit->event === 'delete')
                                                            Eliminó: {{$audit->type}}
                                                        @endif

                                                        @if($audit->event === 'update')
                                                            Editó: {{$audit->type}}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <p class="m-0">{{date_format($audit->created_at, "d/m/Y")}}</p>
                                                    <small>{{$audit->user_level}}</small>
                                                </div>
                                            </div>
                                            @if($audit->event === 'create')
                                                <div class="alert alert-success" role="alert">
                                                    <ul>
                                                        @foreach(json_decode($audit->data) as $key => $data)
                                                            <li>
                                                                {{$key}}: &nbsp; {{$data}}
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                </div>
                                            @endif

                                            @if($audit->event === 'delete')
                                                <div class="alert alert-danger" role="alert">

                                                    <ul>
                                                        @foreach(json_decode($audit->data) as $key => $data)
                                                            <li>
                                                                {{$key}}: &nbsp; {{$data}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            @if($audit->event === 'update')
                                                <div class="alert alert-primary" role="alert">

                                                    <ul>
                                                        @foreach(json_decode($audit->data) as $key => $data)
                                                            <li>
                                                                {{$key}}: &nbsp; {{$data}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
@endsection
