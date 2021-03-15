<div class="table">

{{ Illuminate\Mail\Markdown::parse($slot) }}

@if ( $order && $orderProducts )

<table cellpadding="0" cellspacing="0" border="0" class="order-table">

<thead>
<tr>
<td>@lang('factotum::ecommerce_order.product')</td>
<td>@lang('factotum::ecommerce_order.quantity')</td>
<td>@lang('factotum::ecommerce_order.price')</td>
</tr>
</thead>

<tbody>

@foreach( $orderProducts as $op )

<tr>
<td>
{{ $op->product->name }}
@if ( $op->product->has_variants )
({{ $op->product_variant->label }})
@endif
</td>
<td>{{ $op->quantity }}</td>
<td>€ {{ number_format( $op->quantity * $op->product_price, 2, ',', '.' ) }}</td>
</tr>

@endforeach

<tr>
<td colspan="2"><strong>@lang('factotum::ecommerce_order.total_partial')</strong></td>
<td>€ {{ number_format( $order->total_net + $order->total_tax, 2, ',', '.' )  }}</td>
</tr>

@if( !config('factotum.product_vat_included') )

<tr>
<td colspan="2"><strong>@lang('factotum::ecommerce_order.total_taxes')</strong></td>
<td>€ {{ number_format( $order->total_tax, 2, ',', '.' )  }}</td>
</tr>

@endif

<tr>
<td colspan="2"><strong>@lang('factotum::ecommerce_order.total_shipping')</strong></td>
<td>€ {{ number_format( $order->total_shipping_net + $order->total_shipping_tax, 2, ',', '.' )  }}</td>
</tr>

<tr>
<td colspan="2"><strong>@lang('factotum::ecommerce_order.payment_method')</strong></td>

@if ( $order->payment_type == 'stripe' )
<td>
<strong>@lang('factotum::ecommerce_checkout.credit_or_debit_cart')</strong>
</td>
@endif

@if ( $order->payment_type == 'paypal' )
<td>
<strong>PayPal</strong>
</td>
@endif

@if ( $order->payment_type == 'bank-transfer' )
<td>
<strong>@lang('factotum::ecommerce_checkout.bank_transfer')</strong>
</td>
@endif

@if ( $order->payment_type == 'custom-payment' )
<td>
<strong>@lang('factotum::ecommerce_checkout.custom_payment_in_agreement_with')<br>{{ env('SHOP_OWNER_NAME') }}</strong>
</td>
@endif

</tr>

<tr>
<td colspan="2"><strong>@lang('factotum::ecommerce_order.shipping')</strong></td>

@if( $order->shipping == 'pick_up_standard' )
<td>@lang('factotum::ecommerce_checkout.shipping_pick_up_standard')</td>
@endif

@if( $order->shipping == 'IT_standard' )
<td>@lang('factotum::ecommerce_checkout.shipping_IT_standard')</td>
@endif

@if( $order->shipping == 'IT_express' )
<td>@lang('factotum::ecommerce_checkout.shipping_IT_express')</td>
@endif

@if( $order->shipping == 'other_standard' )
<td>@lang('factotum::ecommerce_checkout.shipping_other_standard')</td>
@endif
</tr>


<tr>
<td colspan="2"><strong>@lang('factotum::ecommerce_order.total')</strong></td>
<td>€ {{ number_format( $order->total_net + $order->total_tax + $order->total_shipping_net + $order->total_shipping_tax, 2, ',', '.' )  }}</td>
</tr>
</tbody>
</table>

@endif
</div>

<div class="table">
	<table cellpadding="0" cellspacing="0" border="0" class="order-table">
		<thead>
			<tr>
				<td colspan="2">@lang('factotum::ecommerce_checkout.delivery_address_title')</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>@lang('factotum::ecommerce_checkout.delivery_address')</td>
				<td>{{ $order->delivery_address }}</td>
			</tr>
			<tr>
				<td>@lang('factotum::ecommerce_checkout.delivery_city')</td>
				<td>{{ $order->delivery_city }}</td>
			</tr>
			<tr>
				<td>@lang('factotum::ecommerce_checkout.delivery_zip')</td>
				<td>{{ $order->delivery_zip }}</td>
			</tr>
			<tr>
				<td>@lang('factotum::ecommerce_checkout.delivery_province')</td>
				<td>{{ $order->delivery_province }}</td>
			</tr>
			<tr>
				<td>@lang('factotum::ecommerce_checkout.delivery_country')</td>
				<td>{{ $order->delivery_country }}</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="table">
	<table cellpadding="0" cellspacing="0" border="0" class="order-table">
		<thead>
		<tr>
			<td colspan="2">@lang('factotum::ecommerce_checkout.invoice_address_title')</td>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>@lang('factotum::ecommerce_checkout.invoice_address')</td>
			<td>{{ $order->invoice_address }}</td>
		</tr>
		<tr>
			<td>@lang('factotum::ecommerce_checkout.invoice_city')</td>
			<td>{{ $order->invoice_city }}</td>
		</tr>
		<tr>
			<td>@lang('factotum::ecommerce_checkout.invoice_zip')</td>
			<td>{{ $order->invoice_zip }}</td>
		</tr>
		<tr>
			<td>@lang('factotum::ecommerce_checkout.invoice_province')</td>
			<td>{{ $order->invoice_province }}</td>
		</tr>
		<tr>
			<td>@lang('factotum::ecommerce_checkout.invoice_country')</td>
			<td>{{ $order->invoice_country }}</td>
		</tr>
		</tbody>
	</table>
</div>


@if ( $order->payment_type == 'bank-transfer' )
<div class="table">
	<table cellpadding="0" cellspacing="0" border="0" class="order-table">
		<thead>
			<tr>
				<td>@lang('factotum::ecommerce_checkout.issue_bank_transfer_to')</td>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{ env('SHOP_OWNER_NAME') }}</td>
		</tr>
		<tr>
			<td>{{ env('SHOP_OWNER_BANK_NAME') }}</td>
		</tr>
		<tr>
			<td>IBAN: {{ env('SHOP_OWNER_BANK_IBAN') }}</td>
		</tr>
		<tr>
			<td>
				Effettua il pagamento tramite bonifico bancario.
				<strong>Usa il numero dell’ordine come causale.</strong><br>
				<u>Il tuo ordine non verrà spedito finché i fondi non risulteranno trasferiti sul nostro conto corrente.</u>
			</td>
		</tr>
		</tbody>
	</table>
</div>
@endif
