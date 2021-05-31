@extends('layouts.app')

@section('content')
<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
    <section class="app-content">
      <div class="row">
        <div class="col-md-12">
          <div class="widget p-lg">
            <a href="{{ url('export') }} " class="btn btn-sm btn-primary float-right ">Exportar
              Excel</a>
            <h4 class="m-b-lg">Clientes que no pagaron</h4>

            <div class="d-none d-lg-block d-xl-block">
              <table class="table agente-not-payments-table">
                <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Lunes</th>
                  <th>Martes</th>
                  <th>Míercoles</th>
                  <th>Jueves</th>
                  <th>Viernes</th>
                  <th>Sábado</th>
                  <th>Domingo</th>
                </tr>
                </thead>

                <tbody>
                @foreach($clients as $client)

                  <tr>
                    <td>{{$client->name}} {{$client->last_name}}</td>
                    <td>
                    <span class="badge {{$client->summary_day['Monday']> 0 ? 'badge-success': 'badge-danger' }}">
                      {{$client->summary_day['Monday'] > 0 ?  $client->summary_day['Monday'] : $client->summary_day['Monday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Tuesday']> 0 ? 'badge-success': 'badge-danger' }}">

                      {{$client->summary_day['Tuesday'] > 0 ?  $client->summary_day['Tuesday'] : $client->summary_day['Tuesday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Wednesday']> 0 ? 'badge-success': 'badge-danger' }}">
                      {{$client->summary_day['Wednesday'] > 0 ?  $client->summary_day['Wednesday'] : $client->summary_day['Wednesday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Thursday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Thursday'] > 0 ?  $client->summary_day['Thursday'] : $client->summary_day['Thursday'] }}

                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Friday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Friday'] > 0 ?  $client->summary_day['Friday'] : $client->summary_day['Friday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Saturday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Saturday'] > 0 ?  $client->summary_day['Saturday'] : $client->summary_day['Saturday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Sunday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Sunday'] > 0 ?  $client->summary_day['Sunday'] : $client->summary_day['Sunday'] }}
                    </span>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>

{{--            MOBILE--}}
            <div class="d-sm-block d-lg-none">
              <table class="table agente-not-payments-table">
                <thead class="d-none">
                  <tr>
                    <th>Cliente</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Míercoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                    <th>Domingo</th>
                  </tr>
                </thead>

                <tbody>
                @foreach($clients as $client)
                  <tr>
                    <td>{{$client->name}} {{$client->last_name}}</td>
                    <td>
                    <span class="badge {{$client->summary_day['Monday']> 0 ? 'badge-success': 'badge-danger' }}">
                      {{$client->summary_day['Monday'] > 0 ?  $client->summary_day['Monday'] : $client->summary_day['Monday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Tuesday']> 0 ? 'badge-success': 'badge-danger' }}">

                      {{$client->summary_day['Tuesday'] > 0 ?  $client->summary_day['Tuesday'] : $client->summary_day['Tuesday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Wednesday']> 0 ? 'badge-success': 'badge-danger' }}">
                      {{$client->summary_day['Wednesday'] > 0 ?  $client->summary_day['Wednesday'] : $client->summary_day['Wednesday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Thursday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Thursday'] > 0 ?  $client->summary_day['Thursday'] : $client->summary_day['Thursday'] }}

                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Friday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Friday'] > 0 ?  $client->summary_day['Friday'] : $client->summary_day['Friday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Saturday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Saturday'] > 0 ?  $client->summary_day['Saturday'] : $client->summary_day['Saturday'] }}
                    </span>
                    </td>
                    <td>
                    <span class="badge {{$client->summary_day['Sunday']> 0 ? 'badge-success': 'badge-danger' }}   ">
                      {{$client->summary_day['Sunday'] > 0 ?  $client->summary_day['Sunday'] : $client->summary_day['Sunday'] }}
                    </span>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>


          </div><!-- .widget -->
        </div>
      </div><!-- .row -->
    </section>
  </div>
</main>
@endsection