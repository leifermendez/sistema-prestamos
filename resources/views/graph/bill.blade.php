@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Gastos</h4>
                            <form class="container" action="{{url('supervisor/graph')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="payment_number">Cobrador:</label>
                                    <select name="agent" class="form-control" id="agent">
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}">
                                                {{$client->name}} {{$client->last_name}}
                                                - {{$client->wallet_name}}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="row align-items-end">
                                    <div class="col-sm-4">
                                        <label for="nit_number"> Fecha Inicial:</label>
                                        <input type="text" name="date_start"  class="form-control datepicker-trigger" id="date_start" required>
                                    </div>
{{--                                    <div class="col-sm-4">--}}
{{--                                        <label for="nit_number"> Fecha Final:</label>--}}
{{--                                        <input type="text" name="date_end"  class="form-control datepicker-trigger" id="date_end" required>--}}
{{--                                    </div>--}}
                                    <div class="col-sm-4">
                                        <button class="btn btn-info hidden" type="submit">Buscar</button>
                                        <a href="{{url('supervisor/graph?type=default')}}" class="btn btn-dark">Regresar</a>
                                    </div>
                                </div>
                                <input type="hidden" name="type" id="type" value="bill">
                            </form>
                            <br class="clearfix">
{{--                            {{json_encode($data)}}--}}
                            <div class="container">
                                @if(count($data)>0)
                                    <input type="hidden" name="dataGraph" id="dataGraph" value="{{json_encode($data)}}">

                                    <div class="mt-3 d-flex flex-wrap justify-content-center">
                                        <div  class="chart-container" style="width: 100vh">
                                            <canvas id="dataDays"></canvas>
                                        </div>
                                    </div>

                                    <div class="mt-3 d-flex flex-wrap justify-content-around">
                                        <div  class="chart-container" style="width: 70vh !important;">
                                            <canvas id="dataAmount"></canvas>
                                        </div>
                                        <div  class="chart-container" style="width: 70vh !important;">
                                            <canvas id="dataItems"></canvas>
                                        </div>
                                    </div>
{{--                                    grafica por dias entre rango de fechas--}}
{{--                                    <div class="pt-4 px-1 container d-flex justify-content-center">--}}
{{--                                        <div style=" position: relative;--}}
{{--                                              margin: auto;--}}
{{--                                              height: 30vh;--}}
{{--                                              width: 100vw;">--}}
{{--                                            <canvas id="dataDays" width="200" height="100"></canvas>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    graficas por rango de fecha--}}
{{--                                    <div class="row pt-5" id="graphs">--}}
{{--                                        <div class="col-sm-6" style=" position: relative;--}}
{{--                                              margin: auto;--}}
{{--                                              height: 30vh;--}}
{{--                                              width: 100vw;">--}}
{{--                                            <canvas id="dataItems" width="200" height="100"></canvas>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6" style=" position: relative;--}}
{{--                                              margin: auto;--}}
{{--                                              height: 30vh;--}}
{{--                                              width: 100vw;">--}}
{{--                                            <canvas id="dataAmount" width="200" height="100"></canvas>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                @endif
                            </div>
                        </div><!-- .widget -->
                    </div>
                </div><!-- .row -->
            </section>
        </div>
    </main>
    <script>
        function load() {
            const dataGraph = JSON.parse(document.getElementById('dataGraph').value);

            graphicsDays(
                dataGraph.dataDays.data,
                dataGraph.dataDays.labels,
                dataGraph.dataDays.total,
                'Dinero gastado por día',
                'dataDays'
            );

            graphics(
                [dataGraph.dataItems.thisWeekend, dataGraph.dataItems.lastWeekend],
                [dataGraph.labels.lastWeekend, dataGraph.labels.thisWeekend],
                'Cantidad de gastos',
                'dataItems'
            );

            graphics(
                [dataGraph.dataAmount.thisWeekend, dataGraph.dataAmount.lastWeekend],
                [dataGraph.labels.lastWeekend, dataGraph.labels.thisWeekend],
                'Dinero gastado por rango',
                'dataAmount'
            );
        }
        setTimeout(function () {
            window.onload = load()
        }, 2000)
    </script>
@endsection