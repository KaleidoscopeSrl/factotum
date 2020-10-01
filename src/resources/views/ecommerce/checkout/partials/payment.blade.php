<div class="box @if( $step == 'payment' ) box-open @endif box-choose-payment">

	<div class="box-header container-fluid col-no-pl col-no-pr">
		<div class="row clearfix">
			<div class="col col-xs-8">

				<h4>
					<strong>4. @lang('factotum::ecommerce_checkout.payment_title')</strong>
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


	<div class="box-expand container-fluid col-no-pl col-no-pr">

		<div class="row clearfix" id="payment-options">

			<div class="col col-xs-12">

				<div class="field field-checkbox">
					<label for="terms_conditions">
						<input type="checkbox" name="terms_conditions" id="terms_conditions" value="1" required>
						@lang('factotum::ecommerce_checkout.agree_terms_conditions')
					</label>
				</div>

				<div class="row clearfix">

					@if ( isset($stripe) && isset($stripe['publicKey']) && $stripe['publicKey'] != '' )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<label for="pay-with-stripe">
									<input type="radio" name="pay-with" id="pay-with-stripe" value="stripe" required>
									@lang('factotum::ecommerce_checkout.credit_or_debit_cart')
								</label>
							</div>
						</div>
					@endif

					@if ( isset($paypal) && isset($paypal['publicKey']) && $paypal['publicKey'] != '' )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<label for="pay-with-paypal">
									<input type="radio" name="pay-with" id="pay-with-paypal" value="paypal" required>
									PayPal
								</label>
							</div>
						</div>
					@endif

					@if ( isset($bankTransfer) && $bankTransfer )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<label for="pay-with-bank-transfer">
									<input type="radio" name="pay-with" id="pay-with-bank-transfer" value="bank-transfer" required>
									@lang('factotum::ecommerce_checkout.bank_transfer')
								</label>
							</div>
						</div>
					@endif

					@if ( isset($customPayment) && $customPayment )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<label for="pay-with-custom-payment">
									<input type="radio" name="pay-with" id="pay-with-custom-payment" value="custom-payment" required>
									@lang('factotum::ecommerce_checkout.custom_payment_in_agreement_with') {{ env('SHOP_OWNER_NAME') }}
								</label>
							</div>
						</div>
					@endif

				</div>

			</div>

			<div class="col col-xs-12">

				@if ( isset($stripe) && isset($stripe['publicKey']) && $stripe['publicKey'] != '' )

					<div class="box box-payment hidden" id="stripe-payment">
						<label for="stripe-card-element">
							@lang('factotum::ecommerce_checkout.credit_or_debit_cart')
						</label>
						<div id="stripe-card-element"></div>
						<div id="stripe-card-errors" class="error" role="alert"></div>

						<div class="cta-container">
							<button class="cta" disabled>@lang('factotum::ecommerce_checkout.pay_with_credit_or_debit_cart')</button>
						</div>
					</div>

				@endif

				@if ( isset($paypal) && isset($paypal['publicKey']) && $paypal['publicKey'] != '' )

					<div class="box box-payment hidden" id="paypal-payment">
						<div class="container-fluid">
							<div class="row clearfix">
								<div class="col col-xs-12 col-sm-6 col-sm-offset-6">

									<div id="paypal-button-container"></div>

								</div>
							</div>
						</div>
					</div>

				@endif

				@if ( isset($bankTransfer) && $bankTransfer )

					<div class="box box-payment hidden" id="bank-transfer-payment">
						<h4>
							@lang('factotum::ecommerce_checkout.issue_bank_transfer_to')<br>
							{{ env('SHOP_OWNER_NAME') }}<br>
							{{ env('SHOP_OWNER_BANK_NAME') }}<br>
							IBAN: {{ env('SHOP_OWNER_BANK_IBAN') }}<br>
						</h4>

						<p>
							@lang('factotum::ecommerce_checkout.pay_with_bank_transfer')
							<strong>@lang('factotum::ecommerce_checkout.use_order_number_as_bank_transfer_subject')</strong><br>
							<u>@lang('factotum::ecommerce_checkout.order_not_sent_until_bank_transfer')</u>
						</p>

						<div class="cta-container tar">
							<button class="cta">@lang('factotum::ecommerce_checkout.pay_with_bank_transfer')</button>
						</div>
					</div>

				@endif

				@if ( isset($customPayment) && $customPayment )

					<div class="box box-payment hidden" id="custom-payment-payment">
						<h4>
							@lang('factotum::ecommerce_checkout.custom_payment_in_agreement_with') {{ $shop['name'] }} e {{ Auth::user()->profile->company_name }}:<br>
						</h4>

						<p>
							-- condizioni di pagamento da CRM --
						</p>

						<div class="cta-container tar">
							<button class="cta">@lang('factotum::ecommerce_checkout.pay')</button>
						</div>
					</div>

				@endif

			</div>

		</div>

	</div>

</div>