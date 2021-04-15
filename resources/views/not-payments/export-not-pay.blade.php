<table class="table agente-transactionV-table">
  <tbody>
    <tr class="visible-lg">
      <th>Cliente</th>
      <th>Lunes</th>
      <th>Martes</th>
      <th>Míercoles</th>
      <th>Jueves</th>
      <th>Viernes</th>
      <th>Sabado</th>
    </tr>

    @foreach ($credit as $cred)
    <tr>
      <td><span class="value">{{ $cred->name }} {{ $cred->last_name }}</span></td>

      @if (count($cred['summary']) > 0)
      @foreach ($cred['summary'] as $c)
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
        <span class="badge {{ $day == 'miércoles' ? 'badge-success' : 'badge-danger' }}">
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
        <span class="badge-danger badge display-4">{{ 0 }}</span>
        </td>

        @endfor
        @endif
    <tr>
      @endforeach

  </tbody>
</table>