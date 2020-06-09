<div class="panel cart-panel">

	@if ( isset($cart) && $cart->products->count() > 0 )
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

		<div class="container-fluid col-no-pl col-no-pr">
			<div class="row clearfix">
				<div class="col col-xs-8 col-sm-7">
					<strong>Totale<br>(iva esclusa)</strong>
				</div>
				<div class="col col-xs-4 col-sm-5 tar">
					&euro; {{ number_format( $total, 2, ',', '.' ) }}
				</div>
			</div>
		</div>

	@endif

	<div class="cta-container tac">
		<a href="/cart" class="cta">VEDI CARRELLO</a>
	</div>
</div>
