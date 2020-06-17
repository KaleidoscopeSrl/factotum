<div class="box @if( $step == 'payment' ) box-open @else box-close @endif box-choose-payment">

	<div class="box-header container-fluid col-no-pl col-no-pr">
		<div class="row clearfix">
			<div class="col col-xs-8">
				<h4 class="cta-aligned">4. Pagamento</h4>
			</div>
			<div class="col col-xs-4 tar">
				<i class="fi flaticon-confirmation green box-on-valid"></i>
			</div>
		</div>
	</div>

	<div class="box-expand container-fluid col-no-pl col-no-pr">

		<div class="row clearfix" id="payment-options">

			<div class="col col-xs-12">
				<div class="field field-checkbox">
					<input type="checkbox" name="terms_conditions" id="terms_conditions" value="1" required>
					<label for="terms_conditions">Accetto i termini e le condizioni d'uso</label>
				</div>

				<div class="row clearfix">

					@if ( isset($stripe) && isset($stripe['publicKey']) && $stripe['publicKey'] != '' )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<input type="radio" name="pay-with" id="pay-with-stripe" value="stripe" required>
								<label for="pay-with-stripe">Carta di Credito o Debito</label>
							</div>
						</div>
					@endif

					@if ( isset($paypal) && isset($paypal['publicKey']) && $paypal['publicKey'] != '' )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<input type="radio" name="pay-with" id="pay-with-paypal" value="paypal" required>
								<label for="pay-with-paypal">Paypal</label>
							</div>
						</div>
					@endif

					@if ( isset($bankTransfer) && $bankTransfer )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<input type="radio" name="pay-with" id="pay-with-bank-transfer" value="bank-transfer" required>
								<label for="pay-with-bank-transfer">Bonifico Bancario</label>
							</div>
						</div>
					@endif

					@if ( isset($customPayment) && $customPayment )
						<div class="col col-xs-6 col-md-6">
							<div class="field field-radio">
								<input type="radio" name="pay-with" id="pay-with-custom-payment" value="custom-payment" required>
								<label for="pay-with-custom-payment">Pagamento concordato con {{ env('SHOP_OWNER_NAME') }}</label>
							</div>
						</div>
					@endif

				</div>

			</div>

			<div class="col col-xs-12">

				@if ( isset($stripe) && isset($stripe['publicKey']) && $stripe['publicKey'] != '' )

					<div class="box box-payment hidden" id="stripe-payment">
						<label for="stripe-card-element">
							Carta di Credito o Debito
						</label>
						<div id="stripe-card-element"></div>
						<div id="stripe-card-errors" class="error" role="alert"></div>

						<div class="cta-container tar">
							<button class="cta" disabled>PAGA CON CARTA DI CREDITO</button>
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
							Bonifico da intesare a:<br>
							{{ env('SHOP_OWNER_NAME') }}<br>
							{{ env('SHOP_OWNER_BANK_NAME') }}<br>
							IBAN: {{ env('SHOP_OWNER_BANK_IBAN') }}<br>
						</h4>

						<p>
							Effettua il pagamento tramite bonifico bancario.
							<strong>Usa il numero dell’ordine come causale.</strong><br>
							<u>Il tuo ordine non verrà spedito finché i fondi non risulteranno trasferiti sul nostro conto corrente.</u>
						</p>

						<div class="cta-container tar">
							<button class="cta">PAGO CON BONIFICO</button>
						</div>
					</div>

				@endif

				@if ( isset($customPayment) && $customPayment )

					<div class="box box-payment hidden" id="custom-payment-payment">
						<h4>
							Pagamento come concordato tra {{ $shop['name'] }} e {{ Auth::user()->profile->company_name }}:<br>
						</h4>

						<p>
							-- condizioni di pagamento da CRM --
						</p>

						<div class="cta-container tar">
							<button class="cta">PROCEDI</button>
						</div>
					</div>

				@endif

			</div>

		</div>

	</div>

</div>