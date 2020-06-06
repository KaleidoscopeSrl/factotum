@extends('layouts.app')

@section('content')

	<section class="page page-register">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/'             => 'Home',
				'/user/profile' => 'Il tuo profilo',
				'#'             => 'Indirizzo di fatturazione'
			]])

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-8">

					<div class="box">

						<h3>Indirizzo di fatturazione</h3>

						<form method="POST" action="/user/invoice-address" class="container-fluid col-no-pl col-no-pr">
							@csrf

							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="invoice_address">Indirizzo</label>

										<input id="invoice_address" type="text"
											   value="{{ $user->profile->invoice_address }}"
											   class="form-control @error('invoice_address') is-invalid @enderror" name="invoice_address"
											   required autofocus>

										@error('invoice_address')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-2">

									<div class="field">
										<label for="invoice_zip">CAP</label>

										<input id="invoice_zip" type="text"
											   maxlength="7"
											   value="{{ $user->profile->invoice_zip }}"
											   class="form-control @error('invoice_zip') is-invalid @enderror" name="invoice_zip"
											   required autofocus>

										@error('invoice_zip')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-4">

									<div class="field">
										<label for="invoice_city">Città</label>

										<input id="invoice_city" type="text"
											   value="{{ $user->profile->invoice_city }}"
											   class="form-control @error('invoice_city') is-invalid @enderror" name="invoice_city"
											   required autofocus>

										@error('invoice_city')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
							</div>


							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="invoice_province">Provincia</label>

										<input id="invoice_province" type="text"
											   value="{{ $user->profile->invoice_province }}"
											   class="@error('invoice_province') is-invalid @enderror" name="invoice_province"
											   required autofocus>

										@error('invoice_province')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="invoice_nation">Nazione</label>

										@php $countries = \Kaleidoscope\Factotum\Library\Utility::getCountries(); @endphp

										<select name="invoice_nation" id="invoice_nation"
												required
												class="@error('invoice_nation') is-invalid @enderror">
											<option value="">Seleziona la nazione</option>
											@foreach ( $countries as $code => $label )
												<option value="{{ $code }}" @if( $code == $user->profile->invoice_nation ) selected @endif>{{ $label }}</option>
											@endforeach
										</select>

										@error('invoice_nation')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
							</div>


							<div class="row clearfix">
								<div class="col col-xs-12">

									<div class="field field-checkbox">
										<input type="checkbox" name="use_for_delivery" id="use_for_delivery" value="1">
										<label for="use_for_delivery">Usa lo stesso indirizzo per la consegna</label>
									</div>

								</div>
							</div>

							<div class="row clearfix">
								<div class="col col-xs-12">

									<div class="cta-container">
										<button type="submit" class="cta">Salva</button>
									</div>

								</div>
							</div>

						</form>

					</div>

				</div>
			</div>
		</div>

	</section>

@endsection
