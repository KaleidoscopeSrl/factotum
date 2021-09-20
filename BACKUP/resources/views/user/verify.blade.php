@extends('layouts.app')

@section('content')

<section class="page page-register">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Verifica Indirizzo Email'
		]])

		<div class="row clearfix">
			<div class="col col-xs-12 col-md-8">

				<div class="box">

					<h3>Verifica indirizzo email</h3>

					@if ( session('resent') )
						<div class="alert alert-success" role="alert">
							Un nuovo link è stato inviato al tuo indirizzo email
						</div>
					@endif

					<br><br>

					<p>
						Prima di procedere, controlla la tua email con il link di verifica.
						<br>
						Se non hai ricevuto l'email
					</p>

					<br><br>

					<form method="POST" action="/user/resend-verification">
						@csrf
						<button type="submit" class="cta">Clicca qui per richiederne un'altra</button>
					</form>

				</div>

			</div>
		</div>

	</div>

</section>

@endsection