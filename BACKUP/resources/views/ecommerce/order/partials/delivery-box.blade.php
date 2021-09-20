<div class="box box-address">
	<h4>Indirizzo di spedizione</h4>

	<span>{{ $order->delivery_address }}</span><br>

	<span>{{ $order->delivery_zip }} - {{ $order->delivery_city }}</span><br>

	<span>{{ $order->delivery_province }}</span><br>

	<span>{{ $order->delivery_country }}</span>

</div>