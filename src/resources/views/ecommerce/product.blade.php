@extends('layouts.app')

@section('content')

<section class="page page-product">

	{{--<pre>{{ print_r($product) }}</pre>--}}

	<div class="container">
		@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/' => 'Home',
				'#' => $product->name
			]])

		<div class="row clearfix">

			<div class="col col-xs-12 col-sm-4">

				<div style="position: fixed; background-color: yellow; color: red; height: 50px; line-height: 50px;">social</div>

				<div class="img-container">
					@if ( $product->image )
						<img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-responsive">
					@else
						<img src="/assets/media/img/product-placeholder.jpg" alt="{{ $product->name }}" class="img-responsive placeholder">
					@endif
				</div>

			</div>
			<div class="col col-xs-12 col-sm-8">

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
					<div class="discounted">
						<strong>€ 2200,00</strong> iva esclusa
					</div>
					<div class="price">
						<strong>€ 1800,00</strong> iva esclusa
					</div>
				</div>

				<div style="background-color: pink; color: red; height: 50px; line-height: 50px;">agg carrello</div>

			</div>

		</div>

	</div>

</section>

@endsection



