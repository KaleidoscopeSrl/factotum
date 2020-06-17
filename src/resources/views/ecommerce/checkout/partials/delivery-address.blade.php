<div class="box @if( $step == 'delivery-address' ) box-open @else box-close @endif @if ( $deliveryAddress ) box-valid @endif box-choose-delivery-address">

	<div class="box-header container-fluid col-no-pl col-no-pr">
		<div class="row clearfix">
			<div class="col col-xs-8">
				<h4 class="cta-aligned">1. Indirizzo di consegna</h4>
			</div>
			<div class="col col-xs-4 tar">
				<a href="{{ '/user/customer-addresses/edit/delivery?back-to-checkout=1' }}" class="cta cta-blue box-on-open">Nuovo Indirizzo</a>
				<i class="fi flaticon-confirmation green box-on-valid"></i>
			</div>
		</div>
	</div>

	<div class="box-expand container-fluid col-no-pl col-no-pr">

		@if ( isset($deliveryAddresses) && $deliveryAddresses->count() > 0 )

			<div class="row clearfix">
				@foreach ( $deliveryAddresses as $d )
					<div class="col col-xs-12 col-sm-6">
						<label for="delivery-address-{{ $d->id }}" class="box box-address box-choose">

							<input type="radio" name="delivery-address"
								   @if ($deliveryAddress && $deliveryAddress->id == $d->id ) checked @endif
								   value="{{ $d->id }}"
								   id="delivery-address-{{ $d->id }}">

							@if ( $d->address != '' )
								<span>{{ $d->address }}</span><br>
							@endif

							@if ( $d->zip != '' && $d->city != '' )
								<span>{{ $d->zip }} - {{ $d->city }}</span><br>
							@endif

							@if ( $d->province != '' )
								<span>{{ $d->province }}</span><br>
							@endif

							@if ( $d->country != '' )
								<span>{{ $d->country }}</span><br>
							@endif

						</label>
					</div>
				@endforeach
			</div>

		@endif

		<div class="cta-container tar">
			<button class="cta" @if( !$deliveryAddress ) disabled @endif>CONTINUA</button>
		</div>

	</div>

</div>