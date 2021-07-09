<div class="panel cart-panel">

	@if ( isset($cart) )

		@if ( isset($cartProducts) && $cartProducts->count() > 0 )
			<ul class="container-fluid col-no-pl col-no-pr">

				@foreach( $cartProducts as $cp )

					<li class="row">
						<a href="{{ $cp->product['abs_url'] }}" class="clearfix">
							<div class="col col-xs-3 col-no-pl col-no-pr">
								<div class="img-container">
									@if ( $cp->product['image'] )
										<img src="{{ $cp->product['image'] }}" alt="{{ $cp->product['name'] }}" class="img-responsive">
									@else
										<img src="/assets/media/img/product-placeholder.jpg" alt="{{ $cp->product['name'] }}" class="img-responsive placeholder">
									@endif
								</div>
							</div>
							<div class="col col-xs-9 col-no-pr">
								<span>
									<strong>{{ $cp->quantity  }}</strong> x {{ $cp->product['name'] }}
									<br>
									<strong>&euro; {{ number_format( $cp->quantity * $cp->product_price, 2, ',', '.' ) }}</strong>
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

				<tr class="discount-code-row @if ( !isset($discountCode) ) hidden @endif">
					<td>
						<span>
							Discount code:
							@if ( isset($discountCode) && $discountCode )
								<strong>{{ $discountCode->code }}</strong>
							@endif
						</span>
					</td>
					<td class="tar">
						<span class="total-discount">- {{ '€ ' . number_format( $totalDiscount, 2, ',', '.' ) }}</span>
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
