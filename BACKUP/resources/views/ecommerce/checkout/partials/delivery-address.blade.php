@php $countries = \Kaleidoscope\Factotum\Library\Utility::getCountries(); @endphp

<div class="box @if( $step == 'delivery-address' ) box-open @endif @if ( $deliveryAddress ) box-valid @endif box-choose-delivery-address">

	<div class="box-header container-fluid col-no-pl col-no-pr">
		<div class="row clearfix">
			<div class="col col-xs-8">

				<h4>
					<strong>1. @lang('factotum::ecommerce_checkout.delivery_address_title')</strong>
					<img src="/assets/img/check.svg" class="confirmation" alt="">
				</h4>

			</div>
			<div class="col col-xs-4 tar">

				@if ( !config('factotum.guest_cart') )
					<a href="{{ '/user/customer-addresses/edit/delivery?back-to-checkout=1' }}" class="cta cta-blue box-on-open">Nuovo Indirizzo</a>
				@endif

				<span class="chevron"></span>
				<span class="chevron bottom"></span>

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

		@if ( config('factotum.guest_cart') )

			<div class="row clearfix">

				<!-- first name -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="first_name">@lang('factotum::ecommerce_checkout.first_name')</label>
						<input type="text" name="first_name" id="first_name"
						       data-pristine-required-message="The First Name is required"
						       required value="@if( old('first_name') ){{ old('first_name') }}@endif">
						<p class="error" role="alert">@error('first_name') {{ $message }} @enderror</p>
					</div>

				</div>

				<!-- last name -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="last_name">@lang('factotum::ecommerce_checkout.last_name')</label>
						<input type="text" name="last_name" id="last_name"
						       data-pristine-required-message="The Last Name is required"
						       required value="@if( old('last_name') ){{ old('last_name') }}@endif">
						<p class="error" role="alert">@error('last_name') {{ $message }} @enderror</p>
					</div>

				</div>

				<!-- company name -->
				<div class="col col-xs-12">

					<div class="field">
						<label for="company_name">@lang('factotum::ecommerce_checkout.company_name')</label>
						<input type="text" name="company_name" id="company_name"
						       value="@if( old('company_name') ){{ old('company_name') }}@endif">
					</div>

				</div>


				<!-- phone -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="phone">@lang('factotum::ecommerce_checkout.phone')</label>
						<input type="phone" name="phone" id="phone"
						       data-pristine-required-message="The Phone is required"
						       required value="@if( old('phone') ){{ old('phone') }}@endif">
						<p class="error" role="alert">@error('phone') {{ $message }} @enderror</p>
					</div>

				</div>

				<!-- email -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="email">@lang('factotum::ecommerce_checkout.email')</label>
						<input type="email" name="email" id="email"
						       data-pristine-required-message="The Email is required"
						       data-pristine-email-message="The Email is not in the right format"
						       required value="@if( old('email') ){{ old('email') }}@endif">
						<p class="error" role="alert">@error('email') {{ $message }} @enderror</p>
					</div>

				</div>


				<!-- address -->
				<div class="col col-xs-12">

					<div class="field">
						<label for="delivery_address">@lang('factotum::ecommerce_checkout.delivery_address')</label>
						<input type="text" name="delivery_address" id="delivery_address"
						       data-pristine-required-message="The Delivery Address is required"
						       required value="@if( old('delivery_address') ){{ old('delivery_address') }}@endif">
						<p class="error" role="alert">@error('delivery_address') {{ $message }} @enderror</p>
					</div>

				</div>

				<!-- address line 2 -->
				<div class="col col-xs-12">

					<div class="field">
						<label for="delivery_address_line_2">@lang('factotum::ecommerce_checkout.delivery_address_line_2')</label>
						<input type="text" name="delivery_address_line_2" id="delivery_address_line_2"
						       value="@if( old('delivery_address_line_2') ){{ old('delivery_address_line_2') }}@endif">
					</div>

				</div>

				<!-- city -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="delivery_city">@lang('factotum::ecommerce_checkout.delivery_city')</label>
						<input type="text" name="delivery_city" id="delivery_city"
						       data-pristine-required-message="The Delivery City is required"
						       required value="@if( old('delivery_city') ){{ old('delivery_city') }}@endif">
						<p class="error" role="alert">@error('delivery_city') {{ $message }} @enderror</p>
					</div>

				</div>

				<!-- zip -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="delivery_zip">@lang('factotum::ecommerce_checkout.delivery_zip')</label>
						<input type="text" name="delivery_zip" id="delivery_zip"
						       data-pristine-required-message="The Delivery Zip is required"
						       data-pristine-minlength-message="The Delivery Zip should be at least 4 characters"
						       data-pristine-maxlength-message="The Delivery Zip should be at maxium 8 characters"
						       required minlength="4" maxlength="8" value="@if( old('delivery_zip') ){{ old('delivery_zip') }}@endif">
						<p class="error" role="alert">@error('delivery_zip') {{ $message }} @enderror</p>
					</div>

				</div>

				<!-- province -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="delivery_province">@lang('factotum::ecommerce_checkout.delivery_province')</label>
						<input type="text" name="delivery_province" id="delivery_province"
						       data-pristine-required-message="The Delivery Province is required"
						       required value="@if( old('delivery_province') ){{ old('delivery_province') }}@endif">
						<p class="error" role="alert">@error('delivery_province') {{ $message }} @enderror</p>
					</div>

				</div>

				<!-- country -->
				<div class="col col-xs-12 col-sm-6">

					<div class="field">
						<label for="delivery_country">@lang('factotum::ecommerce_checkout.delivery_country')</label>
						<select name="delivery_country" id="delivery_country"
						        required
						        data-pristine-required-message="The Delivery Country is required"
						        class="@error('country') is-invalid @enderror">
							<option value="">Select the country</option>
							@foreach ( $countries as $code => $label )
								<option value="{{ $code }}" @if( old('delivery_country') && $code == old('delivery_country') ) selected @endif>{{ $label }}</option>
							@endforeach
						</select>
						<p class="error" role="alert">@error('delivery_country') {{ $message }} @enderror</p>
					</div>

				</div>

			</div>

		@endif

		<div class="cta-container">
			<button class="cta" @if( !$deliveryAddress ) disabled @endif>continue</button>
		</div>

	</div>

</div>