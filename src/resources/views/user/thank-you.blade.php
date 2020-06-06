@extends('layouts.app')

@section('content')

<section class="page page-thankyou">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Grazie'
		]])

		<div class="row clearfix">
			<div class="col col-xs-12 col-md-8">

				<div class="box">

					<h3>Grazie per esserti registrato!</h3>

					<br><br>

					<p>
						Prima di procedere, controlla la tua email con il link di verifica.
					</p>

				</div>

			</div>
		</div>

	</div>

</section>

@endsection