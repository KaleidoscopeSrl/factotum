<div class="box box-address">

	<h4>Indirizzo di fatturazione</h4>

	<span>{{ $order->invoice_address }}</span><br>

	<span>{{ $order->invoice_zip }} - {{ $order->invoice_city }}</span><br>

	<span>{{ $order->invoice_province }}</span><br>

	<span>{{ $order->invoice_country }}</span>

</div>