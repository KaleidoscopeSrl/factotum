<div class="box box-order-details">

	<h4>Dettagli Ordine</h4>

	<table width="100%">
		<tr>
			<td>
				Data ordine
			</td>
			<td>
				<strong>{{ \Carbon\Carbon::createFromTimestampMs( $order->created_at )->format('d/m/Y') }}</strong>
			</td>
		</tr>
		<tr>
			<td>
				Stato ordine
			</td>
			<td>
				<strong>@lang( 'factotum::ecommerce_order.' . $order->status )</strong>
			</td>
		</tr>
		<tr>
			<td>
				Totale parziale
			</td>
			<td>
				<strong>&euro; {{ number_format( $order->total_net, 2, ',', '.' ) }}</strong>
			</td>
		</tr>
		<tr>
			<td>
				Totale tasse
			</td>
			<td>
				<strong>&euro; {{ number_format( $order->total_tax, 2, ',', '.' ) }}</strong>
			</td>
		</tr>
		<tr>
			<td>
				Totale spedizione
			</td>
			<td>
				<strong>&euro; {{ number_format( $order->total_shipping, 2, ',', '.' ) }}</strong>
			</td>
		</tr>
		<tr>
			<td>
				Totale
			</td>
			<td>
				<strong>&euro; {{ number_format( $order->total_net + $order->total_tax + $order->total_shipping, 2, ',', '.' ) }}</strong>
			</td>
		</tr>

		@if ( $order->payment_type )
		<tr>
			<td>
				Pagato con
			</td>
			<td>
				@if ( $order->payment_type == 'stripe' && $order->transaction_id )
					<strong>Carta di Credito / Debito</strong>
				@endif

				@if ( $order->payment_type == 'paypal' && $order->transaction_id )
						<strong>PayPal</strong>
				@endif

				@if ( $order->payment_type == 'bank-transfer' )
					<strong>Bonifico Bancario</strong>
				@endif

				@if ( $order->payment_type == 'custom-payment' )
					<strong>Pagamento concordato con {{ env('SHOP_OWNER_NAME') }}</strong>
				@endif
			</td>
		</tr>
		@endif

	</table>

</div>