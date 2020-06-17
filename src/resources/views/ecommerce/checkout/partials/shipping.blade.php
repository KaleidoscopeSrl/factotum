<div class="box @if( $step == 'shipping' ) box-open @else box-close @endif @if ( $shipping ) box-valid @endif box-choose-shipping">

	<div class="box-header container-fluid col-no-pl col-no-pr">
		<div class="row clearfix">
			<div class="col col-xs-8">
				<h4 class="cta-aligned">3. Spedizione</h4>
			</div>
			<div class="col col-xs-4 tar">
				<i class="fi flaticon-confirmation green box-on-valid"></i>
			</div>
		</div>
	</div>

	<div class="box-expand">

		<div class="box-expand container-fluid col-no-pl col-no-pr">

			<div class="row clearfix" id="shipping-options">

				@if ( !$deliveryAddress )

					<h3>Devi prima selezionare l'indirizzo di consegna.</h3>

				@else

					@include('factotum::ecommerce.ajax.shipping-options', [ 'shipping' => $shipping ] )

				@endif

			</div>

			<div class="row clearfix">
				<div class="col col-xs-12">
					<label for="notes">
						Se vuoi aggiungere un commento al tuo ordine, scrivilo qui sotto.
					</label>
					<textarea id="notes" name="notes"></textarea>
				</div>
			</div>

			<div class="cta-container tar">
				<button class="cta" @if( !$shipping ) disabled @endif>CONTINUA</button>
			</div>

		</div>
	</div>

</div>