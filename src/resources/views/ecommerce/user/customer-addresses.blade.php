@extends('layouts.app')

@section('content')

	<section class="page page-register">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/'             => 'Home',
				'/user/profile' => 'Il tuo profilo',
				'#'             => 'I tuoi indirizzi'
			]])

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-8">

					<div class="box">

						<h3>I tuoi indirizzi</h3>

						<div class="container-fluid col-no-pl col-no-pl">

							<div class="row clearfix">
								<div class="col col-xs-12 tar">
									<a href="{{ '/user/customer-addresses/edit/delivery' }}" class="cta cta-blue">Nuovo Indirizzo</a>
								</div>
							</div>

							<br><br>

							@if ( isset($deliveryAddresses) && $deliveryAddresses->count() > 0 )

							<div class="row clearfix">

								@foreach ( $deliveryAddresses as $d )
									
									<div class="col col-xs-12 col-md-6">

										<div class="box">

											@if ( $d->address != '' )
											<span>{{ $d->address }}</span><br>
											@endif

											@if ( $d->zip != '' && $d->city != '' )
											<span>{{ $d->zip }} - {{ $d->city }}</span><br>
											@endif

											@if ( $d->province != '' )
												<span>{{ $d->province }}</span><br>
											@endif

											@if ( $d->nation != '' )
												<span>{{ $d->nation }}</span><br>
											@endif

											<br>

											<a href="/user/customer-addresses/edit/{{ $d->type }}/{{ $d->id }}" class="cta">Aggiorna</a>
										</div>

									</div>
									
								@endforeach

							</div>

							@endif

						</div>

					</div>
					

					@if ( isset($invoiceAddress) && $invoiceAddress )

					<div class="box">

						<h3>Indirizzo di fatturazione</h3>

						<div class="container-fluid col-no-pl col-no-pl">

							<div class="row clearfix">
								<div class="col col-xs-12 col-md-6">

									@if ( $invoiceAddress->address != '' )
										<span>{{ $invoiceAddress->address }}</span><br>
									@endif

									@if ( $invoiceAddress->zip != '' && $invoiceAddress->city != '' )
										<span>{{ $invoiceAddress->zip }} - {{ $invoiceAddress->city }}</span><br>
									@endif

									@if ( $invoiceAddress->province != '' )
										<span>{{ $invoiceAddress->province }}</span><br>
									@endif

									@if ( $invoiceAddress->nation != '' )
										<span>{{ $invoiceAddress->nation }}</span><br>
									@endif

									<br>

									<a href="/user/customer-addresses/edit/{{ $invoiceAddress->type }}/{{ $invoiceAddress->id }}" class="cta">Aggiorna</a>

								</div>

							</div>
						</div>

					</div>

					@endif

				</div>
			</div>
		</div>

	</section>

@endsection
