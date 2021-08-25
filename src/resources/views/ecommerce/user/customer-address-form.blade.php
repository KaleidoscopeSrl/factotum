@extends('layouts.app')

@section('content')

	<section class="page page-customer-address">

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

						<h3>@if ( !isset($address) ) Nuovo @endif Indirizzo di @if ( $type == 'delivery' ) consegna @else fatturazione @endif</h3>

						<form method="POST"
							  action="/user/customer-addresses/edit/{{ $type }}{{ (isset($address) ? '/' . $address->id : '' ) }}"
							  class="container-fluid col-no-pl col-no-pr">
							@csrf

							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="address">Indirizzo</label>

										<input id="address" type="text"
											   value="@if( isset($address) ){{ $address->address }}@endif"
											   class="form-control @error('address') is-invalid @enderror" name="address"
											   required autofocus>

										@error('address')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-2">

									<div class="field">
										<label for="zip">CAP</label>

										<input id="zip" type="text"
											   maxlength="7"
											   value="@if( isset($address) ){{ $address->zip }}@endif"
											   class="form-control @error('zip') is-invalid @enderror" name="zip"
											   required autofocus>

										@error('zip')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-4">

									<div class="field">
										<label for="city">Città</label>

										<input id="city" type="text"
											   value="@if( isset($address) ){{ $address->city }}@endif"
											   class="form-control @error('city') is-invalid @enderror" name="city"
											   required autofocus>

										@error('city')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
							</div>


							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="prov">Provincia *</label>

										<div class="province-field-wrapper">
											@include('factotum::ecommerce.user.ajax.province-select')
										</div>

										@error('prov')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="country">Nazione</label>

										@php $countries = \Kaleidoscope\Factotum\Library\Utility::getCountries(); @endphp

										<select name="country" id="country"
												required
												class="@error('country') is-invalid @enderror">
											<option value="">Seleziona la nazione</option>
											@foreach ( $countries as $code => $label )
												<option value="{{ $code }}" @if( isset($address) && $code == $address->country ) selected @endif>{{ $label }}</option>
											@endforeach
										</select>

										@error('country')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
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
