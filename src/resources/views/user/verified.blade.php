@extends('layouts.app')

@section('content')

<section class="page page-thankyou">

	<div class="container">

		@include('layouts.breadcrumbs', [
		'breadcrumbs' => [
			'/' => 'Home',
			'#' => 'Email verificata!'
		]])

		<div class="row clearfix">
			<div class="col col-xs-12 col-md-8">

				<div class="box">

					<h3>Email verificata!</h3>

				</div>

			</div>
		</div>

	</div>

</section>

@endsection
