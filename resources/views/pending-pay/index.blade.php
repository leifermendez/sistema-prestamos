@extends('layouts.app')

@section('content')
<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
    <section class="app-content">
      <div class="row">
        <div class="col-md-12">
          <div class="widget p-lg overflow-auto">
            <h4 class="m-b-lg">Clientes pendientes</h4>

            <div class="d-none d-lg-block d-xl-block">
              <table class="table agente-route-table">
                <thead>
                <tr>
                  <th># Credito</th>
                  <th>Nombres</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($clients as $client)
                  <tr id="td_{{$client->id}}">
                    <td>{{$client->id}}</td>
                    <td>{{$client->id}}</td>
                    <td>{{$client->id}}</td>
                    <td>{{$client->user_name}} {{$client->user_last_name}}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>

{{--            MOBILE--}}
            <div class="d-sm-block d-lg-none">
              <table class="table agente-route-table">
                <thead class="d-none">
                  <tr>
                    <th># Credito</th>
                    <th>Nombres</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>

                <tbody>
                @foreach($clients as $client)
                  <tr id="td_{{$client->id}}">
                    <td>{{$client->id}}</td>
                    <td>{{$client->id}}</td>
                    <td>{{$client->id}}</td>
                    <td>{{$client->user_name}} {{$client->user_last_name}}</td>
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
    <!-- APP MAIN ==========-->
{{--    <main id="app-main" class="app-main">--}}
{{--        <div class="wrap">--}}
{{--            <section class="app-content">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="widget p-lg overflow-auto">--}}
{{--                            <h4 class="m-b-lg">Clientes pendientes</h4>--}}

{{--                            <table class="table agente-route-table">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th># Credito</th>--}}
{{--                                    <th>Nombres</th>--}}
{{--                                    <th>Status</th>--}}
{{--                                    <th></th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}

{{--                                <tbody>--}}
{{--                                @foreach($clients as $client)--}}
{{--                                    <tr id="td_{{$client->id}}">--}}
{{--                                        <td>{{$client->id}}</td>--}}
{{--                                        <td>{{$client->id}}</td>--}}
{{--                                        <td>{{$client->id}}</td>--}}
{{--                                        <td>{{$client->user_name}} {{$client->user_last_name}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}

{{--                        </div><!-- .widget -->--}}
{{--                    </div>--}}
{{--                </div><!-- .row -->--}}
{{--            </section>--}}
{{--        </div>--}}
{{--    </main>--}}
{{--@endsection--}}
