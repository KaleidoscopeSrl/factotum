<div class="categories-filter">

	<h3>Filtri veloci</h3>

	<div class="box box-categories">
		<h4>Categorie</h4>
		<?php \Kaleidoscope\Factotum\Helpers\PrintProductCategoriesHelper::print_product_categories( '', ( isset($productCategory) ? $productCategory : null ) ); ?>
	</div>

	@if ( isset($brands) && $brands->count() > 0 )

		<div class="box">
			<h4>Marca</h4>

			<ul class="brands">
				@foreach( $brands as $br )
					<li>
						<div class="flexed">
							<label class="no-link" for="brand_{{ $br->id }}">
								{{ $br->name }}
							</label>
							<div class="no-button">
								<input type="checkbox" name="brands[]"
									   @if( $brandsFilter && in_array( $br->id, $brandsFilter ) ) checked @endif
									   value="{{ $br->id }}" id="brand_{{ $br->id }}" />
							</div>
						</div>
					</li>
				@endforeach
			</ul>

			<div class="cta-container tac">
				<button class="cta cta-blue" id="brands-filter">FILTRA</button>
			</div>

		</div>

	@endif

</div>