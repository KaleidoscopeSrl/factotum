@extends('layouts.app')

@section('content')

<section class="page page-product-category">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => $brand->name
		]])

		<div class="row clearfix">
			<div class="col col-md-3 hidden-xs hidden-sm">

				@include('factotum::ecommerce.product.partials.categories-filter')

			</div>
			<div class="col col-xs-12 col-md-9">

				<div class="product-category-cover">

					<div class="row clearfix">
						<div class="col col-xs-12">
							@if( isset($brand->logo) )
								<img src="{{ $brand->logo }}" alt="{{ $brand->name }}" width="200" />
							@endif
						</div>
					</div>

				</div>


				@include('factotum::ecommerce.product.partials.product-category-filters', [ 'title' => $brand->name ])


				@if ( $products->count() > 0 )

				<div class="products-grid">

					<div class="row clearfix">

						@foreach ( $products as $product )
							<div class="col col-xs-6 col-sm-4 col-lg-3">
								@include( 'partials.single-product-card', [ 'product' => (array)$product ])
							</div>
						@endforeach

					</div>

					@if ( isset($products) && $products instanceof Illuminate\Pagination\LengthAwarePaginator )

						<div class="row clearfix">
							<div class="col col-xs-12 tar">
<?php
$appends = [];

if ( isset($brandFilter) ) {
	$appends[ 'brand_filter' ] = $brandFilter;
}

if ( isset($brandsFilter) ) {
	$appends[ 'brands' ] = join(',', $brandsFilter );
}

if ( isset($itemsPerPage) ) {
	$appends[ 'items_per_page' ] = $itemsPerPage;
}
?>
									{{ $products->appends($appends)->links('factotum::layouts.pagination') }}
							</div>
						</div>

					@endif

				</div>

				@else

					<h1>
						<em>Non ci sono prodotti</em>
					</h1>

				@endif

			</div>
		</div>
	</div>

</section>

@endsection



