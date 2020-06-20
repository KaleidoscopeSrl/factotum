@extends('layouts.app')

@section('content')

	<section class="page page-order">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/' => 'Home',
				'#' => 'I tuoi Ordini'
			]])

			<div class="row clearfix">
				<div class="col col-xs-12">

					<div class="box">

						@if ( $orders->count() > 0 )

							<ul class="orders-list container-fluid col-no-pl col-no-pr">

								@foreach( $orders as $o )
									<li class="row clearfix">
										<div class="col col-xs-3">
											<h4 class="cta-aligned">Ordine n. {{ $o->id }}</h4>
										</div>
										<div class="col col-xs-3">
											Data:<br>
											{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $o->created_at)->format('d/m/Y') }}
										</div>
										<div class="col col-xs-3">
											Stato:<br>
											@lang( 'factotum::ecommerce_order.' . $o->status )
										</div>
										<div class="col col-xs-3 tar">
											<a href="{{ 'order/detail/' . $o->id }}" class="cta cta-only-icon">
												<i class="fi flaticon-loupe"></i>
											</a>
										</div>
									</li>
								@endforeach

							</ul>
						@else

							<h2>Non ci sono ordini</h2>

						@endif

					</div>

				</div>

			</div>

		</div>

	</section>


@endsection



