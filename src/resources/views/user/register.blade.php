@extends('layouts.app')

@section('content')

<section class="page page-register">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Registrati'
		]])

		<div class="row clearfix">
			<div class="col col-xs-12 col-md-8">

				<div class="box">

					<h3>Registrati</h3>

					<form method="POST" action="/user/register" class="container-fluid col-no-pl col-no-pr">
						@csrf

						<div class="row clearfix">
							<div class="col col-xs-12 col-md-6">

								<div class="field">
									<label for="fiscal_code">Codice Fiscale (o Partita Iva)</label>

									<input id="fiscal_code" type="text"
										   class="form-control @error('fiscal_code') is-invalid @enderror" name="fiscal_code"
										   value="{{ old('fiscal_code') }}" required autofocus>

									@error('fiscal_code')
									<p class="error" role="alert">{{ $message }}</p>
									@enderror
								</div>

							</div>
						</div>

						<div class="row clearfix">
							<div class="col col-xs-12 col-md-6">

								<div class="field">
									<label for="first_name">Nome</label>

									<input id="first_name" type="text"
										   class="form-control @error('first_name') is-invalid @enderror" name="first_name"
										   value="{{ old('first_name') }}" required autofocus>

									@error('first_name')
									<p class="error" role="alert">{{ $message }}</p>
									@enderror
								</div>

							</div>
							<div class="col col-xs-12 col-md-6">

								<div class="field">
									<label for="last_name">Cognome</label>

									<input id="last_name" type="text"
										   class="form-control @error('last_name') is-invalid @enderror" name="last_name"
										   value="{{ old('last_name') }}" required autofocus>

									@error('last_name')
									<p class="error" role="alert">{{ $message }}</p>
									@enderror
								</div>

							</div>
						</div>


						<div class="row clearfix">
							<div class="col col-xs-12 col-md-6">

								<div class="field">
									<label for="email">Email</label>

									<input id="email" type="email"
										   class="@error('email') error @enderror" name="email"
										   value="{{ old('email') }}" required autocomplete="email" autofocus>

									@error('email')
									<p class="error" role="alert">{{ $message }}</p>
									@enderror
								</div>

							</div>
							<div class="col col-xs-12 col-md-6">

								<div class="field">
									<label for="phone">Telefono</label>

									<input id="phone" type="tel"
										   class="@error('phone') error @enderror" name="phone"
										   value="{{ old('phone') }}" required autocomplete="phone" autofocus>

									@error('phone')
									<p class="error" role="alert">{{ $message }}</p>
									@enderror
								</div>

							</div>
						</div>


						<div class="row clearfix">
							<div class="col col-xs-12 col-md-6">

								<div class="field">
									<label for="password">Password</label>

									<input id="password" type="password"
										   class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

									@error('password')
									<p class="error" role="alert">{{ $message }}</p>
									@enderror
								</div>

							</div>
							<div class="col col-xs-12 col-md-6">

								<div class="field">
									<label for="password-confirm">Conferma Password</label>

									<input id="password-confirm" type="password"
										   class="@error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>

									@error('password_confirmation')
									<p class="error" role="alert">{{ $message }}</p>
									@enderror
								</div>

							</div>
						</div>

						<div class="row clearfix">
							<div class="col col-xs-12">

								<div class="field field-checkbox">
									<input type="checkbox" name="newsletter" id="newsletter" value="1">
									<label for="newsletter">Iscriviti alla nostra newsletter</label>
								</div>

							</div>
							<div class="col col-xs-12">

								<div class="field field-checkbox">
									<input type="checkbox" name="privacy" id="privacy" value="1">
									<label for="privacy">
										Dichiaro di aver letto, compreso ed acquisito
										l'informativa sulla privacy ai sensi dell’art. 13
										del D.Lgs. 196/2003
									</label>
								</div>

							</div>
							<div class="col col-xs-12">

								<div class="field field-checkbox">
									<input type="checkbox" name="terms_conditions" id="terms_conditions" value="1">
									<label for="terms_conditions">Accetto i termini e le condizioni d'uso</label>
								</div>

							</div>
							<div class="col col-xs-12">

								<div class="field field-checkbox">
									<input type="checkbox" name="partner_offers" id="partner_offers" value="1">
									<label for="partner_offers">Voglio ricevere le offerte dei partners</label>
								</div>

							</div>
							<div class="col col-xs-12">

								<div class="cta-container">
									<button type="submit" class="cta">Registrati</button>
								</div>

							</div>
						</div>

					</form>

					<div class="other-links">
						<a href="/auth/login">Torna al login</a>
					</div>

				</div>

			</div>
		</div>
	</div>

</section>

@endsection
