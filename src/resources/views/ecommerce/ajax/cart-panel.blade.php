<div class="panel cart-panel">

	@if ( isset($cart) )

		@if ( isset($cart->products) && $cart->products->count() > 0 )
			<ul class="container-fluid col-no-pl col-no-pr">

				@foreach( $cart->products as $p )

					<li class="row">
						<a href="{{ $p['abs_url'] }}" class="clearfix">
							<div class="col col-xs-3 col-no-pl col-no-pr">
								<div class="img-container">
									@if ( $p['image'] )
										<img src="{{ $p['image'] }}" alt="{{ $p['name'] }}" class="img-responsive">
									@else
										<img src="/assets/media/img/product-placeholder.jpg" alt="{{ $p['name'] }}" class="img-responsive placeholder">
									@endif
								</div>
							</div>
							<div class="col col-xs-9 col-no-pr">
								<span>
									<strong>{{ $p->pivot->quantity  }}</strong> x {{ $p->name }}
									<br>
									<strong>&euro; {{ number_format( $p->pivot->quantity * $p->pivot->product_price, 2, ',', '.' ) }}</strong>
								</span>
							</div>
						</a>
					</li>

				@endforeach

			</ul>

			<table>

				<tr>
					<td>
						<strong>Totale parziale</strong>
					</td>
					<td class="tar">
						{{ '€ ' . number_format( $totalPartial, 2, ',', '.' ) }}
					</td>
				</tr>

				<tr>
					<td>
						<strong>Totale tasse</strong>
					</td>
					<td class="tar">
						{{ '€ ' . number_format( $totalTaxes, 2, ',', '.' ) }}
					</td>
				</tr>

				<tr>
					<td>
						<strong>Spedizione</strong>
					</td>
					<td class="tar">
						<strong>
							@if( $totalShipping )
								{{ '€ ' . number_format( $totalShipping, 2, ',', '.' ) }}
							@else
								-
							@endif
						</strong>
					</td>
				</tr>

				<tr>
					<td>
						<strong>Totale (tasse incluse)</strong>
					</td>
					<td class="tar">
						<strong>{{ '€ ' . number_format( $total, 2, ',', '.' ) }}</strong>
					</td>
				</tr>

			</table>


			<div class="cta-container tac">
				<a href="/cart" class="cta">VEDI CARRELLO</a>
			</div>

		@else

			<div class="container-fluid col-no-pl col-no-pr">
				<h4>Non ci sono prodotti</h4>
			</div>

		@endif

	@endif

</div>
