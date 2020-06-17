@extends('layouts.app')

@section('content')


<section class="page page-cart">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Carrello'
		]])

		<div class="row clearfix">
			<div class="col col-xs-12 col-md-7">

				<div class="box">

					@if ( $cartProducts && $cartProducts->count() > 0 )

						<ul class="carts-products-list container-fluid col-no-pl col-no-pr">

							@foreach( $cartProducts as $cp )

								<li class="row clearfix" data-product-id="{{ $cp->product['id'] }}">
									<div class="col col-xs-3 col-sm-2 col-no-pr">

										<div class="img-container">
											@if ( $cp->product['image'] && $cp->product['thumb'] )
												<img src="{{ $cp->product['thumb'] }}" alt="{{ $cp->product['name'] }}" class="img-responsive">
											@else
												<img src="/assets/media/img/product-placeholder.jpg" alt="{{ $cp->product['name'] }}" class="img-responsive placeholder">
											@endif
										</div>

									</div>
									<div class="col col-xs-9 col-sm-5 col-md-4">

										<div class="title-container">
											<h4>{{ $cp->product['name'] }}</h4>
										</div>

									</div>
									<div class="col col-xs-9 col-xs-push-3 col-sm-4 col-sm-push-0 clearfix col-no-pl col-no-pr">

										<form class="add-to-cart-widget clearfix"
											  method="POST" action="/cart/add-product">
											@csrf

											<input type="hidden" name="product_id" value="{{ $cp->product['id'] }}">

											<div class="quantity-widget">
												<input type="text" class="quantity" name="quantity" min="1" value="{{ $cp->quantity }}">
												<button class="increase increase-quick">+</button>
												<button class="decrease decrease-quick">-</button>
											</div>

										</form>

										<div class="price-container">
											&euro; {{ number_format( $cp->quantity * $cp->product_price, 2, ',', '.' ) }}
										</div>

									</div>

									<div class="col col-xs-9 col-xs-push-3 col-sm-1 col-sm-push-0 col-md-2">
										<button class="drop-product" data-product-id="{{ $cp->product['id'] }}">
											<i class="fi flaticon-trash"></i>
										</button>
									</div>

								</li>

							@endforeach

						</ul>

					@else

						<h2>Non ci sono prodotti</h2>

					@endif

				</div>

				<a href="{{ url('') }}">
					<h3>Continua lo shopping</h3>
				</a>

			</div>
			<div class="col col-xs-12 col-md-5">

				@include('factotum::ecommerce.cart.partials.cart-recap')

			</div>
		</div>
	</div>

</section>


@endsection



