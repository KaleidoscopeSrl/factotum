@extends('layouts.app')

@section('content')

<section class="page page-product-category">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => $productCategory->label
		]])

		<div class="row clearfix">
			<div class="col col-md-3 hidden-xs hidden-sm">

				<div class="categories-filter">

					<h3>Filtri veloci</h3>

					<div class="box">
						<?php \Kaleidoscope\Factotum\Helpers\PrintProductCategoriesHelper::print_product_categories( '', $productCategory ); ?>
					</div>
				</div>

			</div>
			<div class="col col-xs-12 col-md-9">

				<div class="product-category-cover">

					<div class="row clearfix">
						<div class="col col-xs-12">
							@if( isset($productCategory->image[0]) )
								<div class="img-container">
									<img src="{{ $productCategory->image[0]->url }}" alt="{{ $productCategory->label }}" class="img-responsive"/>
								</div>
							@endif

							<p>{{ $productCategory->description }}</p>
						</div>
					</div>

				</div>

				<div class="product-category-filters">

					<div class="row clearfix">

						<div class="col col-xs-12 col-sm-5">
							<h1>{{ $productCategory->label }}</h1>
						</div>

						<div class="col col-xs-12 col-sm-7">

							<div class="container-fluid col-no-pl col-no-pr">
								<div class="row clearfix">
									<div class="col col-xs-6 col-sm-6">

										<div class="field field-inline">
											<label for="items_per_page">Mostra</label>

											<!-- TODO: cambiare in 12, 24, 38, 96 -->
											<select name="items_per_page" id="items_per_page">
												<option value="1" @if( $itemsPerPage == 1 ) selected @endif>12</option>
												<option value="2" @if( $itemsPerPage == 2 ) selected @endif>24</option>
												<option value="4" @if( $itemsPerPage == 4 ) selected @endif>48</option>
												<option value="9" @if( $itemsPerPage == 9 ) selected @endif>96</option>
											</select>
										</div>

									</div>
									<div class="col col-xs-12 col-sm-6">

										@if ( isset($brands) && $brands->count() > 0 )
											<div class="field field-inline">
												<label for="brand_filter">Filtra per</label>

												<select name="brand_filter" id="brand_filter">
													<option value="">Brand</option>
													@foreach( $brands as $br )
														<option value="{{ $br->id }}" @if( $brandFilter == $br->id ) selected @endif>{{ $br->name }}</option>
													@endforeach
												</select>
											</div>
										@endif

									</div>
								</div>
							</div>

						</div>

					</div>

				</div>

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



