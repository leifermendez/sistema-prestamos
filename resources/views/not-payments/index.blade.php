@extends('layouts.app')

@section('content')
<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget p-lg">
                        <a href="{{ url('export') }} " class="btn btn-sm btn-primary float-right">Exportar
                            Excel</a>
                        <h4 class="m-b-lg">Clientes que no pagaron</h4>
                        <table class="table agente-transactionV-table">
                            <tbody>
                                <tr class="visible-lg">
                                    <th>Cliente</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Míercoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                    <th>Sábado</th>
                                </tr>
                                @foreach ($clients as $client)
                                @if (count($client['summary']) > 0)
                                <tr>
                                    <td><span class="value">{{ $client->name }} {{ $client->last_name }}</span></td>
                                    @if (count($client['summary']) > 0)
                                    @foreach ($client['summary'] as $c)
                                    @php
                                    $day = Carbon\Carbon::parse($c->created_at)->isoFormat('dddd');
                                    @endphp
                                    <td>
                                        <span class="badge {{ $day == 'lunes' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $day == 'lunes' ? $c->amount : 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $day == 'mártes' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $day == 'mártes' ? $c->amount : 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $day == 'miércoles' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $day == 'miércoles' ? $c->amount : 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $day == 'jueves' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $day == 'jueves' ? $c->amount : 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $day == 'viernes' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $day == 'viernes' ? $c->amount : 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $day == 'sabado' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $day == 'sabado' ? $c->amount : 0 }}
                                        </span>
                                    </td>
                                    @endforeach

                                    @else
                                    @for ($i = 0; $i < 6; $i++) <td>
                                        <span class="badge-danger badge">{{ 0 }}</span>
                                        </td>
                                        @endfor
                                        @endif
                                <tr>

                                    @endif
                                    @endforeach

                            </tbody>
                        </table>
                    </div><!-- .widget -->
                </div>
            </div><!-- .row -->
        </section>
    </div>
</main>
@endsection