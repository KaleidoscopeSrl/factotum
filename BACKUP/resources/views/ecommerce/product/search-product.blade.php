@extends('layouts.app')

@section('content')

<section class="page page-product-search">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Ricerca Prodotti'
		]])

		<div class="row clearfix">

			<div class="col col-xs-12">

				@if ( count($products) > 0 )

					<h1>{{ count($products) }} prodotti trovati</h1>

					<div class="products-grid">

						<div class="row clearfix">

							@foreach ( $products as $p )
								<div class="col col-xs-6 col-sm-4 col-lg-2">
									@include( 'partials.single-product-card', [ 'product' => $p ])
								</div>
							@endforeach

						</div>

					</div>

				@else

					<h1>
						<em>Non sono stati trovati prodotti</em>
					</h1>

				@endif

			</div>
		</div>
	</div>

</section>

@endsection



