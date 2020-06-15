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

				<div class="field field-radio">
					<div class="row clearfix">
						<div class="col col-xs-6">
							<input type="radio" name="pay-with" id="pay-with-stripe" value="stripe" required>
							<label for="pay-with-stripe">Carta di Credito o Debito</label>
						</div>
						<div class="col col-xs-6">
							<input type="radio" name="pay-with" id="pay-with-paypal" value="stripe" required>
							<label for="pay-with-paypal">Paypal</label>
						</div>
					</div>
				</div>

			</div>

			<div class="col col-xs-12">

				@if ( isset($stripe) && isset($stripe['publicKey']) && $stripe['publicKey'] != '' )

					<div class="box box-payment hidden" id="stripe-payment">
						<label for="stripe-card-element">
							Carta di Credito o Debito
						</label>
						<div id="stripe-card-element"></div>
						<div id="stripe-card-errors" role="alert"></div>

						<div class="cta-container tar">
							<button class="cta">PAGA CON CARTA DI CREDITO</button>
						</div>
					</div>

				@endif

				<div class="box box-payment hidden" id="paypal-payment">
					<h1>paypal</h1>
				</div>
			</div>

		</div>

	</div>

</div>