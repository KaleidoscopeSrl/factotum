<div class="product-category-filters">

	<div class="row clearfix">

		<div class="col col-xs-12 col-sm-5">
			@if( isset($title) )
			<h1>{{ $title }}</h1>
			@endif
		</div>

		<div class="col col-xs-12 col-sm-7">

			<div class="container-fluid col-no-pl col-no-pr">
				<div class="row clearfix">
					<div class="col col-xs-6 col-sm-6">

						<div class="field field-inline">
							<label for="items_per_page">Mostra</label>

							<select name="items_per_page" id="items_per_page">
								<option value="12" @if( $itemsPerPage == 12 ) selected @endif>12</option>
								<option value="24" @if( $itemsPerPage == 24 ) selected @endif>24</option>
								<option value="48" @if( $itemsPerPage == 48 ) selected @endif>48</option>
								<option value="96" @if( $itemsPerPage == 96 ) selected @endif>96</option>
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
										<option value="{{ $br->id }}" @if( !isset($brandsFiltered) && $brandFilter == $br->id ) selected @endif>{{ $br->name }}</option>
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