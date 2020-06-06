@extends('layouts.app')

@section('content')

	<section class="page page-register">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/'             => 'Home',
				'/user/profile' => 'Il tuo profilo',
				'#'             => 'Indirizzo di consegna'
			]])

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-8">

					<div class="box">

						<h3>Indirizzo di consegna</h3>

						<form method="POST" action="/user/delivery-address" class="container-fluid col-no-pl col-no-pr">
							@csrf

							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="delivery_address">Indirizzo</label>

										<input id="delivery_address" type="text"
											   value="{{ $user->profile->delivery_address }}"
											   class="form-control @error('delivery_address') is-invalid @enderror" name="delivery_address"
											   required autofocus>

										@error('delivery_address')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-2">

									<div class="field">
										<label for="delivery_zip">CAP</label>

										<input id="delivery_zip" type="text"
											   maxlength="7"
											   value="{{ $user->profile->delivery_zip }}"
											   class="form-control @error('delivery_zip') is-invalid @enderror" name="delivery_zip"
											   required autofocus>

										@error('delivery_zip')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-4">

									<div class="field">
										<label for="delivery_city">Città</label>

										<input id="delivery_city" type="text"
											   value="{{ $user->profile->delivery_city }}"
											   class="form-control @error('delivery_city') is-invalid @enderror" name="delivery_city"
											   required autofocus>

										@error('delivery_city')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
							</div>


							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="delivery_province">Provincia</label>

										<input id="delivery_province" type="text"
											   value="{{ $user->profile->delivery_province }}"
											   class="@error('delivery_province') is-invalid @enderror" name="delivery_province"
											   required autofocus>

										@error('delivery_province')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="delivery_nation">Nazione</label>

										@php $countries = \Kaleidoscope\Factotum\Library\Utility::getCountries(); @endphp

										<select name="delivery_nation" id="delivery_nation"
												required
												class="@error('delivery_nation') is-invalid @enderror">
											<option value="">Seleziona la nazione</option>
											@foreach ( $countries as $code => $label )
												<option value="{{ $code }}" @if( $code == $user->profile->delivery_nation ) selected @endif>{{ $label }}</option>
											@endforeach
										</select>

										@error('delivery_nation')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
							</div>


							<div class="row clearfix">
								<div class="col col-xs-12">

									<div class="field field-checkbox">
										<input type="checkbox" name="use_for_invoice" id="use_for_invoice" value="1">
										<label for="use_for_invoice">Usa lo stesso indirizzo per la fatturazione</label>
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
