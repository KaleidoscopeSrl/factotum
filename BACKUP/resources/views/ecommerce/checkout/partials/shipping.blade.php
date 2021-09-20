<div class="box @if( $step == 'shipping' ) box-open @endif @if ( $shipping ) box-valid @endif box-choose-shipping">

	<div class="box-header container-fluid col-no-pl col-no-pr">
		<div class="row clearfix">
			<div class="col col-xs-8">

				<h4>
					<strong>3. @lang('factotum::ecommerce_checkout.shipping_title')</strong>
					<img src="/assets/img/check.svg" class="confirmation" alt="">
				</h4>

			</div>
			<div class="col col-xs-4 tar">

				<span class="chevron"></span>
				<span class="chevron bottom"></span>

			</div>
		</div>
	</div>


	<div class="box-expand">

		<div class="box-expand container-fluid col-no-pl col-no-pr">

			<div class="row clearfix" id="shipping-options">

				@if ( !$deliveryAddress )

					<h4>@lang('factotum::ecommerce_checkout.select_delivery_address_first')</h4>

				@else

					@include('factotum::ecommerce.ajax.shipping-options', [ 'shipping' => $shipping ] )

				@endif

			</div>

			<div class="row clearfix">
				<div class="col col-xs-12">
					<label for="notes">
						@lang('factotum::ecommerce_checkout.additional_notes')
					</label>
					<textarea id="notes" name="notes"></textarea>
				</div>
			</div>

			<div class="cta-container">
				<button class="cta" @if( !$shipping ) disabled @endif>continue</button>
			</div>

		</div>
	</div>

</div>