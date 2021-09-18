@extends('layouts.app')

@section('content')

<section class="page page-login">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Accedi'
		]])

		<div class="row clearfix">
			<div class="col col-xs-12 col-md-6">

				<div class="box">

					<h3>
						Effettua il login
					</h3>

					<form method="POST" action="/auth/login">
						@csrf

						<div class="field">
							<label for="email">Email</label>

							<input id="email" type="email"
								   class="@error('email') error @enderror" name="email"
								   value="{{ old('email') }}" required autocomplete="email" autofocus>

							@error('email')
							<p class="error" role="alert">@lang( 'factotum::auth.' . $message )</p>
							@enderror
						</div>

						<div class="field">

							<label for="password">Password</label>

							<input id="password" type="password"
								   class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

							@error('password')
							<p class="error" role="alert">@lang( 'factotum::auth.' . $message )</p>
							@enderror

						</div>

						<div class="field field-checkbox">
							<input type="checkbox" name="remember" id="remember" value="1">
							<label for="remember">Ricordami</label>
						</div>

						<div class="cta-container">
							<button type="submit" class="cta">Login</button>
						</div>

					</form>

					<div class="other-links">

						<a href="/auth/forgot-password">Password dimenticata?</a>

						<br><br>

						Non sei ancora registrato? <a href="/user/register">Registrati</a>

					</div>

				</div>

			</div>
		</div>
	</div>

</section>

@endsection
