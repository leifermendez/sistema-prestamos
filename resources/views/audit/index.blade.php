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
                                                    <p class="m-0">{{$audit->user_name}} {{$audit->user_last_name}}
                                                    </p>
                                                    <small>
                                                        @if($audit->event === 'create')
                                                            Creó: {{$audit->type}}
                                                        @endif

                                                        @if($audit->event === 'delete')
                                                            Eliminó: {{$audit->type}}
                                                        @endif

                                                        @if($audit->event === 'update')
                                                            Editó: {{$audit->type}}
                                                        @endif
                                                    </small>

{{--                                                    <small>Dispositivo: {{$audit->device}}</small>--}}
                                                </div>
                                                <div class="col-6 text-right">
                                                    <p class="m-0">{{date_format($audit->created_at, "d/m/Y g:i A")}}</p>
                                                    <small>{{$audit->user_level}}</small>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-6">
                                                    <div class="alert alert-info " role="alert">
                                                        <ul>
                                                            @foreach(json_decode($audit->device) as $key => $data)
                                                                @if (str_contains($data, 'https'))
                                                                    <li>
                                                                        {{$key}}: &nbsp; <a href="{{$data}}" target="_blank">Ver en GoogleMaps</a>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        {{$key}}: &nbsp; {{$data}}
                                                                    </li>
                                                                @endIf

                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    @if($audit->event === 'create')
                                                        <div class="alert text-left alert-success" role="alert">
                                                            <ul>
                                                                @foreach(json_decode($audit->data) as $key => $data)
                                                                    <li>
                                                                        @if (($key == 'created_at' || $key == 'updated_at')
                                                                                && (!empty($data) || !is_null($data)))
{{--                                                                                fecha {{$key}}: &nbsp; {{$data}}--}}
                                                                            {{$key}}: &nbsp; {{date_format(new DateTime($data), "d/m/Y g:i A")}}
                                                                        @else
                                                                            {{$key}}: &nbsp; {{$data}}
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>

                                                        </div>
                                                    @endif

                                                    @if($audit->event === 'delete')
                                                        <div class="alert text-left alert-danger" role="alert">

                                                            <ul>
                                                                @foreach(json_decode($audit->data) as $key => $data)
                                                                    <li>
                                                                        @if (($key == 'created_at' || $key == 'updated_at')
                                                                                && (!empty($data) || !is_null($data)))
                                                                            {{--                                                                                fecha {{$key}}: &nbsp; {{$data}}--}}
                                                                            {{$key}}: &nbsp; {{date_format(new DateTime($data), "d/m/Y g:i A")}}
                                                                        @else
                                                                            {{$key}}: &nbsp; {{$data}}
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    @if($audit->event === 'update')
                                                        <div class="alert text-left alert-primary" role="alert">

                                                            <ul>
                                                                @foreach(json_decode($audit->data) as $key => $data)
                                                                    <li>
                                                                        @if (($key == 'created_at' || $key == 'updated_at')
                                                                                && (!empty($data) || !is_null($data)))
                                                                            {{--                                                                                fecha {{$key}}: &nbsp; {{$data}}--}}
                                                                            {{$key}}: &nbsp; {{date_format(new DateTime($data), "d/m/Y g:i A")}}
                                                                        @else
                                                                            {{$key}}: &nbsp; {{$data}}
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
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
