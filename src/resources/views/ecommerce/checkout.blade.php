@extends('layouts.app')

@section('content')

<section class="page page-checkout">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Checkout'
		]])

		<form method="post" action="{{ url('/checkout') }}" id="checkout-form">
			@csrf

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-7">

					@include('factotum::ecommerce.checkout.delivery-address')

					@include('factotum::ecommerce.checkout.invoice-address')

					@include('factotum::ecommerce.checkout.shipping')

					@include('factotum::ecommerce.checkout.payment')

<pre>
Delivery: {{ session()->get('delivery_address') }}<br>
Invoice: {{ session()->get('invoice_address') }}<br>
Shipping: {{ session()->get('shipping') }}<br>
</pre>
				</div>
				<div class="col col-xs-12 col-md-5">

					@include('factotum::ecommerce.cart.cart-recap', [ 'hideCta' => true ])

				</div>
			</div>

		</form>

	</div>

</section>


@if ( isset($stripe) && isset($stripe['publicKey']) && $stripe['publicKey'] != '' )
	<script src="https://js.stripe.com/v3/"></script>
	<script type="text/javascript">
		var stripePublicKey = '{{ $stripe['publicKey'] }}';
	</script>
@endif

@endsection



