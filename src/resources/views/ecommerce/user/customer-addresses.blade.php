@extends('layouts.app')

@section('content')

	<section class="page page-customer-addresses customer-addresses">

		<div class="container">

			@include('layouts.breadcrumbs', [
			'breadcrumbs' => [
				'/'             => 'Home',
				'/user/profile' => 'Il tuo profilo',
				'#'             => 'I tuoi indirizzi'
			]])

			<div class="row clearfix">
				<div class="col col-xs-12 col-md-6">

					<div class="box">

						<div class="container-fluid col-no-pl col-no-pr">
							<div class="row clearfix">
								<div class="col col-xs-12 col-md-8">
									<h3 class="cta-aligned">Indirizzi di consegna</h3>
								</div>
								<div class="col col-xs-12 col-md-4 tar">
									<a href="{{ '/user/customer-addresses/edit/delivery' }}" class="cta cta-blue">Nuovo Indirizzo</a>
								</div>
							</div>
						</div>

						<br>

						<div class="container-fluid col-no-pl col-no-pr">

							@if ( isset($deliveryAddresses) && $deliveryAddresses->count() > 0 )

							<div class="row clearfix">

								@foreach ( $deliveryAddresses as $d )
									
									<div class="col col-xs-12 col-sm-6 col-md-12">

										<div class="box box-address @if( $d->default_address ) default @endif" data-address-id="{{ $d->id }}">

											<strong class="default-address @if( !$d->default_address ) hidden @endif">
												Indirizzo Preferito
											</strong>

											@if ( $d->address != '' )
											<span>{{ $d->address }}</span><br>
											@endif

											@if ( $d->address_line_2 != '' )
												<span>{{ $d->address_line_2 }}</span><br>
											@endif

											@if ( $d->zip != '' && $d->city != '' )
											<span>{{ $d->zip }} - {{ $d->city }}</span><br>
											@endif

											@if ( $d->province != '' )
												<span>{{ $d->province }}</span><br>
											@endif

											@if ( $d->country != '' )
												<span>{{ $d->country }}</span><br>
											@endif

											<div class="cta-container clearfix">

												<a href="/user/customer-addresses/edit/{{ $d->type }}/{{ $d->id }}" class="cta">Aggiorna</a>

												<button class="cta cta-blue set-default-address @if( $d->default_address ) hidden @endif" data-address-id="{{ $d->id }}">Imposta come preferito</button>

												<button class="cta cta-red remove-address" data-address-id="{{ $d->id }}">Elimina</button>
											</div>

										</div>

									</div>
									
								@endforeach

							</div>

							@endif

						</div>

					</div>

				</div>

				<div class="col col-xs-12 col-md-6">

					<div class="box">

						<div class="container-fluid col-no-pl col-no-pr">
							<div class="row clearfix">
								<div class="col col-xs-12 col-md-8">
									<h3 class="cta-aligned">Indirizzo di fatturazione</h3>
								</div>
								<div class="col col-xs-12 col-md-4 tar">
									<a href="{{ '/user/customer-addresses/edit/invoice' }}" class="cta cta-blue">Nuovo Indirizzo</a>
								</div>
							</div>
						</div>

						<br>

						<div class="container-fluid col-no-pl col-no-pr">

							@if ( isset($invoiceAddresses) && $invoiceAddresses->count() > 0 )

								<div class="row clearfix">

									@foreach ( $invoiceAddresses as $i )

										<div class="col col-xs-12 col-sm-6 col-md-12">

											<div class="box box-address @if( $i->default_address ) default @endif" data-address-id="{{ $i->id }}">

												<strong class="default-address @if( !$i->default_address ) hidden @endif">
													Indirizzo Preferito
												</strong>

												@if ( $i->address != '' )
													<span>{{ $i->address }}</span><br>
												@endif

												@if ( $i->address_line_2 != '' )
													<span>{{ $i->address_line_2 }}</span><br>
												@endif

												@if ( $i->zip != '' && $i->city != '' )
													<span>{{ $i->zip }} - {{ $i->city }}</span><br>
												@endif

												@if ( $i->province != '' )
													<span>{{ $i->province }}</span><br>
												@endif

												@if ( $i->country != '' )
													<span>{{ $i->country }}</span><br>
												@endif

												<div class="cta-container clearfix">
													<a href="/user/customer-addresses/edit/{{ $i->type }}/{{ $i->id }}" class="cta">Aggiorna</a>

													<button class="cta cta-blue set-default-address @if( $i->default_address ) hidden @endif" data-address-id="{{ $i->id }}">Imposta come preferito</button>

													<button class="cta cta-red remove-address" data-address-id="{{ $i->id }}">Elimina</button>
												</div>

											</div>

										</div>

									@endforeach

								</div>

							@endif

						</div>

					</div>

				</div>

			</div>
		</div>

	</section>

@endsection
