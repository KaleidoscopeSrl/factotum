@extends('layouts.app')

@section('content')

<section class="page page-forgot-password">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Recupero Password'
		]])

		<div class="row clearfix">
			<div class="col col-xs-12 col-md-6">

				<div class="box">

					<h3>Recupera Password</h3>

					<form method="POST" action="/auth/send-reset-email">
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

						<div class="cta-container">
							<button type="submit" class="cta">Recupera Password</button>
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
