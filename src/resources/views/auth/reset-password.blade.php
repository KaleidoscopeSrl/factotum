@extends('layouts.app')

@section('content')

	<section class="page page-forgot-password">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/' => 'Home',
				'#' => 'Reset Password'
			]])

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-6">

					<div class="box">

						<h3>Reset Password</h3>

						@if (session('status'))
							<div class="alert alert-success" role="alert">
								@lang( 'factotum::auth.' . session('status') )
							</div>
						@endif

						<form method="POST" action="/auth/reset-password">
							@csrf

							<input type="hidden" name="token" value="{{ $token }}">

							<div class="field">
								<label for="email">Email</label>

								<input id="email" type="email"
									   class="@error('email') error @enderror" name="email"
									   value="{{ old('email') }}" required autocomplete="email" autofocus>

								@error('email')
								<p class="error" role="alert">{{ $message }}</p>
								@enderror
							</div>


							<div class="field">
								<label for="password">Password</label>

								<input id="password" type="password"
									   class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

								@error('password')
								<p class="error" role="alert">{{ $message }}</p>
								@enderror
							</div>


							<div class="field">
								<label for="password-confirm">Conferma Password</label>

								<input id="password-confirm" type="password"
									   class="@error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">

								@error('password_confirmation')
								<p class="error" role="alert">{{ $message }}</p>
								@enderror
							</div>


							<div class="cta-container">
								<button type="submit" class="cta">Reset Password</button>
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

