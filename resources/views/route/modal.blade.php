<div id="openModal{{$client->id}}" class="modalDialog">
    <div>
        <a href="#close" title="Close" class="close">X</a>
        <h4 class="widget-title">Abono de cuota</h4>

        <form method="POST" class="payment-create" action="{{url('summary')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Nombres:</label>
                <input type="text" name="name" value ="{{$client->user->name}} {{$client->user->last_name}}" readonly class="form-control" id="name">
            </div>
            <input type="hidden" name="rev" value="{{ app('request')->input('rev') }}">
            <div class="form-group">
                <label for="address">Número de credito:</label>
                <input type="text" name="credit_id" value="{{$client->id}}" readonly class="form-control" id="address">
            </div>
            <div class="form-group">
                <label for="province">Valor de venta:</label>
                <input type="text" name="province" value="{{$client->amount_total}} en {{$client->payment_number}} cuotas" readonly class="form-control" id="province">
            </div>
            <div class="form-group">
                <label for="phone">Pagado:</label>
                <input type="tel" name="phone" value="{{$client->positive}}" readonly class="form-control" id="phone">
            </div>
            <div class="form-group">
                <label for="phone">Saldo:</label>
                <input type="tel" name="phone" value="{{$client->rest}}" readonly class="form-control" id="phone">
            </div>
            <div class="form-group">
                <label for="amount">Valor de cuota:</label>
                <input type="text" readonly value="{{$client->payment_quote}}" class="form-control" id="amount1">
            </div>
            <div class="form-group">
                <label for="amount">Cuotas pagadas:</label>
                <input type="text" readonly value="{{$client->payment_done}}" class="form-control" id="amount2">
            </div>
            <div class="form-group">
                <label for="amount">Valor de abono:</label>
                <input type="number" step="any" min="1" max="{{$client->rest}}" value="{{($client->rest < $client->payment_quote) ? $client->rest : $client->payment_quote}}" name="amount" class="form-control" id="amount">
            </div>
            <div class="form-group">
                <button type="submit" {{($client->rest<1) ? 'disabled': ''}} class="btn btn-success btn-block btn-md">Guardar pago</button>
            </div>
        </form>
    </div>
</div>