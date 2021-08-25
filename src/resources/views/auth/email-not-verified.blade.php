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

					<br>

					<p>
						Prima di procedere, controlla la tua email con il link di verifica.
					</p>

				</div>

			</div>
		</div>

	</div>

</section>

@endsection