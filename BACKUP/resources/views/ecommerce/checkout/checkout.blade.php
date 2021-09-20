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

					@include('factotum::ecommerce.checkout.partials.delivery-address')

					@include('factotum::ecommerce.checkout.partials.invoice-address')

					@include('factotum::ecommerce.checkout.partials.shipping')

					@include('factotum::ecommerce.checkout.partials.payment')

					<div class="error">
						@if($errors->any())
							{{ implode('', $errors->all('<div>:message</div>')) }}
						@endif
					</div>
				</div>
				<div class="col col-xs-12 col-md-5">

					@include('factotum::ecommerce.cart.partials.cart-recap', [ 'hideCta' => true ])

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

@if ( isset($paypal) && isset($paypal['publicKey']) && $paypal['publicKey'] != '' )
	<script src="https://www.paypal.com/sdk/js?client-id={{ $paypal['publicKey'] }}&currency=EUR&disable-funding=card,bancontact,blik,eps,giropay,ideal,mybank,p24,sepa,sofort,venmo"></script>
	<script type="text/javascript">
        var paypalPublicKey = '{{ $paypal['publicKey'] }}';
	</script>
@endif

@endsection



