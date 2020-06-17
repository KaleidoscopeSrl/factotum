@extends('layouts.app')

@section('content')

<section class="page page-product">

	@php
	$breadcrumbs = [
		'/' => 'Home',
	];

	if ( count($categories) > 0 ) {
		$catUrl = '';
		foreach ( $categories as $cat ) {
			$catUrl .= '/' . $cat->name;
			$breadcrumbs[ $catUrl ] = $cat->label;
		}
	}

	$breadcrumbs['#'] = $product->name;
	@endphp

	<div class="container">

		@include('layouts.breadcrumbs', [ 'breadcrumbs' => $breadcrumbs ])

		@include('partials.socials', [ 'title' => $product->name, 'url' => url()->current() ])

		<div class="row clearfix">

			<div class="col col-xs-12 col-sm-6 col-md-4">

				<div class="img-container">
					@if ( $product->image )
						<img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-responsive">
					@else
						<img src="/assets/media/img/product-placeholder.jpg" alt="{{ $product->name }}" class="img-responsive placeholder">
					@endif
				</div>

			</div>
			<div class="col col-xs-12 col-sm-6 col-md-8">

				<h1>{{ $product->name }}</h1>

				<ul class="attributes">
					<li>
						Riferimento <span>{{ $product->code }}</span>
					</li>
					@if ( $product->barcode )
					<li>
						Barcode <span>{{ $product->barcode }}</span>
					</li>
					@endif
				</ul>

				<p>{{ $product->description }}</p>

				<div class="prices">
					@if ( $product['discount_price'] != '' && $product['discount_price'] != 0 )

						<div class="price discounted">
							<strong>€ {{ number_format( $product['basic_price'], 2, ',', '.' ) }}</strong> iva esclusa
						</div>
						<div class="price">
							<strong>€ {{ number_format( $product['discount_price'], 2, ',', '.' ) }}</strong> iva esclusa
						</div>

					@else

						<div class="price">
							<strong>€ {{ number_format( $product['basic_price'], 2, ',', '.' ) }}</strong> iva esclusa
						</div>

					@endif
				</div>

				<div style="background-color: pink; color: red; height: 50px; line-height: 50px;">agg carrello</div>

			</div>

		</div>

	</div>

</section>

@endsection



