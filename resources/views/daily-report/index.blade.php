@extends('layouts.app')

@section('content')
    <!-- APP MAIN ==========-->
    <main id="app-main" class="app-main">
        <div class="wrap">
            <section class="app-content">
                <div class="d-flex flex-wrap justify-content-center">
                    @foreach($data as $item)
                        <div class="widget m-2 stats-widget widget-resume">
                            <div class="widget-body clearfix h-100 bg-white">
                                <div class="pull-left">
                                    <h3 class="widget-title text-dark">{{$item->name}}</h3>
                                    <h3 class="widget-title text-dark">DISPONIBLE (CAJA)</h3>
                                    <h3 class="widget-title text-dark">
                                        <h5> + Base Inicial = <span class=""> {{$item->base_final}}</span>
                                            <h5> + Cobrado = <span class=""> {{$item->total_summary}}</span>
                                                <h5> - Prestado = {{$item->base_credit}}</h5>
                                                <h5> - Gastos = {{$item->total_bill}} </h5>
                                                <h5> ---------------------</h5>
                                                <h5 class="text-success"> Caja = {{($item->base_agent - $item->total_bill) + $item->total_summary}}</h5>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </main>
@endsection
