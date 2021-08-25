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

					<div class="box">

						<h3>Il tuo profilo</h3>

						@if ( isset($completeProfile) )
							<h2 class="red">@lang('factotum::user.should_complete_profile')</h2>
						@endif

						<form method="POST" action="/user/profile" class="container-fluid col-no-pl col-no-pr">
							@csrf

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

									<div class="field field-checkbox">
										<input type="checkbox" name="newsletter" id="newsletter" @if( $user->profile->newsletter ) checked="checked" @endif value="1">
										<label for="newsletter">Iscriviti alla nostra newsletter</label>
									</div>

								</div>
								<div class="col col-xs-12">

									<div class="field field-checkbox">
										<input type="checkbox" name="privacy" id="privacy" @if( $user->profile->privacy ) checked="checked" @endif value="1">
										<label for="privacy">
											Dichiaro di aver letto, compreso ed acquisito
											l'informativa sulla privacy ai sensi dell’art. 13
											del D.Lgs. 196/2003
										</label>
									</div>

								</div>
								<div class="col col-xs-12">

									<div class="field field-checkbox">
										<input type="checkbox" name="terms_conditions" id="terms_conditions" @if( $user->profile->terms_conditions ) checked="checked" @endif value="1">
										<label for="terms_conditions">Accetto i termini e le condizioni d'uso</label>
									</div>

								</div>
								<div class="col col-xs-12">

									<div class="cta-container">
										<button type="submit" class="cta">Salva</button>
									</div>

								</div>
							</div>

						</form>

					</div>


					<div class="box">

						<div class="container-fluid">
							<div class="row clearfix">
								<div class="col col-xs-8">
									<h3 class="cta-aligned">I tuoi indirizzi</h3>
								</div>
								<div class="col col-xs-4 tar">
									<a href="{{ url('/user/customer-addresses') }}" class="cta">VEDI TUTTI</a>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>

	</section>

@endsection
