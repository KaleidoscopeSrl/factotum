@extends('layouts.app')

@section('content')

	<section class="page page-register">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/' => 'Home',
				'#' => 'Il tuo profilo'
			]])

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-8">

					@if ( session('status') )
						<div class="alert alert-success" role="alert">
							{{ session('status') }}

							<button>
								<i class="fi flaticon-trash"></i>
							</button>
						</div>
					@endif

					<div class="box">

						<h3>Il tuo profilo</h3>

						<form method="POST" action="/user/profile" class="container-fluid col-no-pl col-no-pr">
							@csrf

							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="fiscal_code">Codice Fiscale (o Partita Iva)</label>

										<input id="fiscal_code" type="text"
											   class="form-control @error('fiscal_code') is-invalid @enderror" name="fiscal_code"
											   value="{{ $user->fiscal_code }}"  required autofocus>

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
											   value="{{ $user->profile->first_name }}"
											   class="form-control @error('first_name') is-invalid @enderror" name="first_name"
											   required autofocus>

										@error('first_name')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="last_name">Cognome</label>

										<input id="last_name" type="text"
											   value="{{ $user->profile->last_name }}"
											   class="form-control @error('last_name') is-invalid @enderror" name="last_name"
											   required autofocus>

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
											   value="{{ $user->email }}" required autocomplete="email" autofocus>

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
											   value="{{ $user->profile->phone }}" required autocomplete="phone" autofocus>

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
											   class="@error('password') is-invalid @enderror" name="password" autocomplete="new-password">

										@error('password')
										<p class="error" role="alert">{{ $message }}</p>
										@enderror
									</div>

								</div>
								<div class="col col-xs-12 col-md-6">

									<div class="field">
										<label for="password-confirm">Conferma Password</label>

										<input id="password-confirm" type="password"
											   class="@error('password_confirmation') is-invalid @enderror" name="password_confirmation">

										@error('password_confirmation')
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


					<div class="box">

						<h3>I tuoi indirizzi</h3>

						<div class="container-fluid col-no-pl col-no-pl">

							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									<h4>Indirizzo di consegna</h4>

									@if ( $user->profile->delivery_address != '' )
									<span>{{ $user->profile->delivery_address }}</span><br>
									@endif

									@if ( $user->profile->delivery_zip != '' && $user->profile->delivery_city != '' )
									<span>{{ $user->profile->delivery_zip }} - {{ $user->profile->delivery_city }}</span><br>
									@endif

									@if ( $user->profile->delivery_province != '' )
										<span>{{ $user->profile->delivery_province }}</span><br>
									@endif

									@if ( $user->profile->delivery_nation != '' )
										<span>{{ $user->profile->delivery_nation }}</span><br>
									@endif

									<br>
									<a href="/user/delivery-address" class="cta">Aggiorna</a>

								</div>
								<div class="col col-xs-12 col-md-6">

									<h4>Indirizzo di fatturazione</h4>

									@if ( $user->profile->invoice_address != '' )
										<span>{{ $user->profile->invoice_address }}</span><br>
									@endif

									@if ( $user->profile->invoice_zip != '' && $user->profile->invoice_city != '' )
										<span>{{ $user->profile->invoice_zip }} - {{ $user->profile->invoice_city }}</span><br>
									@endif

									@if ( $user->profile->invoice_province != '' )
										<span>{{ $user->profile->invoice_province }}</span><br>
									@endif

									@if ( $user->profile->invoice_nation != '' )
										<span>{{ $user->profile->invoice_nation }}</span><br>
									@endif

									<br>
									<a href="/user/invoice-address" class="cta">Aggiorna</a>
								</div>
							</div>

						</div>

					</div>

				</div>
			</div>
		</div>

	</section>

@endsection
