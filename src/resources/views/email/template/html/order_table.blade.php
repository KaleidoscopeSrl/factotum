<div class="table">
{{ Illuminate\Mail\Markdown::parse($slot) }}
@if ( $order && $orderProducts )
<table cellpadding="0" cellspacing="0" border="0" class="order-table">
	<thead>
		<tr>
			<td>Prodotto</td>
			<td>Quantità</td>
			<td>Prezzo</td>
		</tr>
	</thead>
	<tbody>
@foreach( $orderProducts as $op )
		<tr>
			<td>{{ $op->product->name }}</td>
			<td>{{ $op->quantity }}</td>
			<td>€ {{ number_format( $op->quantity * $op->product_price, 2, ',', '.' ) }}</td>
		</tr>
@endforeach
		<tr>
			<td colspan="2"><strong>Totale parziale</strong></td>
			<td>€ {{ number_format( $order->total_net, 2, ',', '.' )  }}</td>
		</tr>
		<tr>
			<td colspan="2"><strong>Totale tasse</strong></td>
			<td>€ {{ number_format( $order->total_tax, 2, ',', '.' )  }}</td>
		</tr>
		<tr>
			<td colspan="2"><strong>Totale spedizione</strong></td>
			<td>€ {{ number_format( $order->total_shipping, 2, ',', '.' )  }}</td>
		</tr>
		<tr>
			<td colspan="2"><strong>Metodo di pagamento</strong></td>
@if ( $order->payment_type == 'stripe' )
<td>
	<strong>Carta di Credito / Debito</strong>
</td>
@endif

@if ( $order->payment_type == 'paypal' )
<td>
	<strong>PayPal</strong>
</td>
@endif

@if ( $order->payment_type == 'bank-transfer' )
<td>
	<strong>Bonifico Bancario</strong>
</td>
@endif

@if ( $order->payment_type == 'custom-payment' )
<td>
	<strong>Pagamento concordato con<br>{{ env('SHOP_OWNER_NAME') }}</strong>
</td>
@endif
</tr>
<tr>
	<tr>
		<td colspan="2"><strong>Totale</strong></td>
		<td>€ {{ number_format( $order->total_net + $order->total_tax + $order->total_shipping, 2, ',', '.' )  }}</td>
	</tr>
</tr>
</tbody>
</table>
@endif
</div>

<div class="table">
	<table cellpadding="0" cellspacing="0" border="0" class="order-table">
		<thead>
			<tr>
				<td colspan="2">Indirizzo di spedizione</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Indirizzo</td>
				<td>{{ $order->delivery_address }}</td>
			</tr>
			<tr>
				<td>Città</td>
				<td>{{ $order->delivery_city }}</td>
			</tr>
			<tr>
				<td>CAP</td>
				<td>{{ $order->delivery_zip }}</td>
			</tr>
			<tr>
				<td>Provincia</td>
				<td>{{ $order->delivery_province }}</td>
			</tr>
			<tr>
				<td>Stato</td>
				<td>{{ $order->delivery_country }}</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="table">
	<table cellpadding="0" cellspacing="0" border="0" class="order-table">
		<thead>
		<tr>
			<td colspan="2">Indirizzo di fatturazione</td>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>Indirizzo</td>
			<td>{{ $order->invoice_address }}</td>
		</tr>
		<tr>
			<td>Città</td>
			<td>{{ $order->invoice_city }}</td>
		</tr>
		<tr>
			<td>CAP</td>
			<td>{{ $order->invoice_zip }}</td>
		</tr>
		<tr>
			<td>Provincia</td>
			<td>{{ $order->invoice_province }}</td>
		</tr>
		<tr>
			<td>Stato</td>
			<td>{{ $order->invoice_country }}</td>
		</tr>
		</tbody>
	</table>
</div>