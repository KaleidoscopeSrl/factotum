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

					<h1>Complimenti!</h1>
					<h3>Abbiamo ricevuto il tuo ordine (#{{ $order->id }})</h3>

					<br><br>

					<p>
						Il tuo acquisto è andato a buon fine.<br>
						Riceverai un email di conferma.
					</p>

					<p>
						Torna a trovarci!
					</p>

				</div>

			</div>
		</div>

	</div>

</section>

@endsection