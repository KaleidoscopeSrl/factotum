@extends('layouts.app')

@section('content')

	<section class="page page-order">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/'      => 'Home',
				'/order' => 'I tuoi ordini',
				'#'      => 'Ordine n. ' . $order->id
			]])

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-7">

					@include('factotum::ecommerce.order.partials.details-table')

					<div class="container-fluid col-no-pl col-no-pr">
						<div class="row clearfix">
							<div class="col col-xs-12 col-sm-6">
								@include('factotum::ecommerce.order.partials.delivery-box')
							</div>
							<div class="col col-xs-12 col-sm-6">
								@include('factotum::ecommerce.order.partials.invoice-box')
							</div>
						</div>
					</div>

					@if ( $orderProducts->count() > 0 )

						<div class="box">

							<ul class="order-products-list container-fluid col-no-pl col-no-pr">

								@foreach( $orderProducts as $op )

									<li class="row clearfix">
										<div class="col col-xs-3 col-sm-2 col-no-pr">

											<div class="img-container">
												@if ( $op->product['image'] && $op->product['thumb'] )
													<img src="{{ $op->product['thumb'] }}" alt="{{ $op->product['name'] }}" class="img-responsive">
												@else
													<img src="/assets/media/img/product-placeholder.jpg" alt="{{ $op->product['name'] }}" class="img-responsive placeholder">
												@endif
											</div>

										</div>
										<div class="col col-xs-9 col-sm-5 col-md-4">

											<div class="title-container">
												<h4>{{ $op->product['name'] }}</h4>
											</div>

										</div>
										<div class="col col-xs-9 col-xs-push-3 col-sm-4 col-sm-push-0 clearfix col-no-pl col-no-pr">

											<div class="price-container">
												&euro; {{ number_format( $op->quantity * $op->product_price, 2, ',', '.' ) }}
											</div>

										</div>

									</li>

								@endforeach

							</ul>

						</div>

					@endif

					<a href="{{ url('/order/list') }}">
						<h3>Torna indietro</h3>
					</a>

				</div>
				<div class="col col-xs-12 col-md-5">

					<?php // TODO: banners ?>

				</div>
			</div>
		</div>

	</section>


@endsection



