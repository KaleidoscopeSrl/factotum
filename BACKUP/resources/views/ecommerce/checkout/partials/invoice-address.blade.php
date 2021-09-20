@php $countries = \Kaleidoscope\Factotum\Library\Utility::getCountries(); @endphp

<div class="box @if( $step == 'invoice-address' ) box-open @endif @if ( $invoiceAddress ) box-valid @endif box-choose-invoice-address">

	<div class="box-header container-fluid col-no-pl col-no-pr">
		<div class="row clearfix">
			<div class="col col-xs-8">

				<h4>
					<strong>2. @lang('factotum::ecommerce_checkout.invoice_address_title')</strong>
					<img src="/assets/img/check.svg" class="confirmation" alt="">
				</h4>

			</div>
			<div class="col col-xs-4 tar">

				@if ( !config('factotum.guest_cart') )
					<a href="{{ '/user/customer-addresses/edit/invoice?back-to-checkout=1' }}" class="cta cta-blue box-on-open">Nuovo Indirizzo</a>
				@endif

				<span class="chevron"></span>
				<span class="chevron bottom"></span>

			</div>
		</div>
	</div>


	<div class="box-expand">

		<div class="box-expand container-fluid col-no-pl col-no-pr">

			@if ( isset($invoiceAddresses) && $invoiceAddresses->count() > 0 )

				<div class="row clearfix">
					@foreach ( $invoiceAddresses as $i )
						<div class="col col-xs-12 col-sm-6">
							<label for="invoice-address-{{ $i->id }}" class="box box-address box-choose">
								<input type="radio" name="invoice-address"
								       @if ($invoiceAddress && $invoiceAddress->id == $i->id ) checked @endif
								       value="{{ $i->id }}" id="invoice-address-{{ $i->id }}">

								@if ( $i->address != '' )
									<span>{{ $i->address }}</span><br>
								@endif

								@if ( $i->zip != '' && $i->city != '' )
									<span>{{ $i->zip }} - {{ $i->city }}</span><br>
								@endif

								@if ( $i->province != '' )
									<span>{{ $i->province }}</span><br>
								@endif

								@if ( $i->country != '' )
									<span>{{ $i->country }}</span><br>
								@endif

							</label>
						</div>
					@endforeach
				</div>

			@endif


			@if ( config('factotum.guest_cart') )

				<div class="row clearfix">

					<!-- same address as invoice -->
					<div class="col col-xs-12">

						<div class="field">
							<label for="same_address_as_invoice">
								<input type="checkbox" name="same_address_as_invoice" id="same_address_as_invoice"
								       @if( !old('form_already_sent') || old('same_address_as_invoice') ) checked @endif
								       value="true">
								@lang('factotum::ecommerce_checkout.use_same_address_as_invoice_address')
							</label>
						</div>

					</div>

					<div class="same_address_as_invoice hidden">

						<!-- address -->
						<div class="col col-xs-12">

							<div class="field">
								<label for="invoice_address">@lang('factotum::ecommerce_checkout.invoice_address')</label>
								<input type="text" name="invoice_address" id="invoice_address"
								       data-pristine-required-message="The Invoice Address is required"
								       required value="@if( old('invoice_address') ){{ old('invoice_address') }}@endif">
								<p class="error" role="alert">@error('invoice_address') {{ $message }} @enderror</p>
							</div>

						</div>

						<!-- address line 2 -->
						<div class="col col-xs-12">

							<div class="field">
								<label for="invoice_address_line_2">@lang('factotum::ecommerce_checkout.invoice_address_line_2')</label>
								<input type="text" name="invoice_address_line_2" id="invoice_address_line_2"
								       value="@if( old('invoice_address_line_2') ){{ old('invoice_address_line_2') }}@endif">
							</div>

						</div>

						<!-- city -->
						<div class="col col-xs-12 col-sm-6">

							<div class="field">
								<label for="invoice_city">@lang('factotum::ecommerce_checkout.invoice_city')</label>
								<input type="text" name="invoice_city" id="invoice_city"
								       data-pristine-required-message="The Invoice City is required"
								       required value="@if( old('invoice_city') ){{ old('invoice_city') }}@endif">
								<p class="error" role="alert">@error('invoice_city') {{ $message }} @enderror</p>
							</div>

						</div>

						<!-- zip -->
						<div class="col col-xs-12 col-sm-6">

							<div class="field">
								<label for="invoice_zip">@lang('factotum::ecommerce_checkout.invoice_zip')</label>
								<input type="text" name="invoice_zip" id="invoice_zip"
								       data-pristine-required-message="The Invoice Zip is required"
								       data-pristine-minlength-message="The Invoice Zip should be at least 4 characters"
								       data-pristine-maxlength-message="The Invoice Zip should be at maxium 8 characters"
								       required minlength="4" maxlength="8" value="@if( old('invoice_zip') ){{ old('invoice_zip') }}@endif">
								<p class="error" role="alert">@error('invoice_zip') {{ $message }} @enderror</p>
							</div>

						</div>

						<!-- province -->
						<div class="col col-xs-12 col-sm-6">

							<div class="field">
								<label for="invoice_province">@lang('factotum::ecommerce_checkout.invoice_province')</label>
								<input type="text" name="invoice_province" id="invoice_province"
								       data-pristine-required-message="The Invoice Province is required"
								       required value="@if( old('invoice_province') ){{ old('invoice_province') }}@endif">
								<p class="error" role="alert">@error('invoice_province') {{ $message }} @enderror</p>
							</div>

						</div>

						<!-- country -->
						<div class="col col-xs-12 col-sm-6">

							<div class="field">
								<label for="invoice_country">@lang('factotum::ecommerce_checkout.invoice_country')</label>
								<select name="invoice_country" id="invoice_country"
								        required
								        data-pristine-required-message="The Invoice Country is required"
								        class="@error('country') is-invalid @enderror">
									@foreach ( $countries as $code => $label )
										<option value="{{ $code }}" @if( old('invoice_country') && $code == old('invoice_country') ) selected @endif>{{ $label }}</option>
									@endforeach
								</select>
								<p class="error" role="alert">@error('invoice_country') {{ $message }} @enderror</p>
							</div>

						</div>

					</div>

				</div>

			@endif

			<div class="cta-container">
				@if ( config('factotum.guest_cart') )
					<button class="cta">continue</button>
				@else
					<button class="cta" @if( !$invoiceAddress ) disabled @endif>continue</button>
				@endif
			</div>

		</div>
	</div>

</div>