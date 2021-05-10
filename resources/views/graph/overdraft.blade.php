@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget p-lg">
                            <h4 class="m-b-lg">Prestamos</h4>
                            <form action="{{url('admin/graph')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="d-flex justify-content-around align-items-center">
                                    <div>
                                        <label for="nit_number"> Fecha Inicial:</label>
                                        <input type="text" name="date_start"  class="form-control datepicker-trigger" id="date_start" required>
                                    </div>
                                    <div>
                                        <label for="nit_number"> Fecha Final:</label>
                                        <input type="text" name="date_end"  class="form-control datepicker-trigger" id="date_end" required>
                                    </div>
                                    <input type="hidden" name="type" id="type" value="overdraft">

                                    <button class="btn btn-info hidden" type="submit">Buscar</button>
                                </div>
                            </form>
                            <br class="clearfix">

                            <div class="container">
                                @if(count($data)>0)
                                    <input type="hidden" name="dataGraph" id="dataGraph" value="{{json_encode($data)}}">
                                    <div class="row" id="graphs">
                                        <div class="col-sm-6 px-5">
                                            <canvas id="dataItems" width="200" height="100"></canvas>
                                        </div>
                                        <div class="col-sm-6 px-5">
                                            <canvas id="dataAmount" width="200" height="100"></canvas>
                                        </div>
                                    </div>
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
            overdraft(
                [dataGraph.dataItems.thisWeekend, dataGraph.dataItems.lastWeekend],
                [dataGraph.thisWeekend, dataGraph.lastWeekend],
                'Prestamos otorgados',
                'dataItems'
            );

            overdraft(
                [dataGraph.dataAmount.thisWeekend, dataGraph.dataAmount.lastWeekend],
                [dataGraph.thisWeekend, dataGraph.lastWeekend],
                'Dinero prestado',
                'dataAmount'
            );
            console.log('load', dataGraph)
        }
        setTimeout(function () {
            window.onload = load()
        }, 2000)
    </script>
@endsection