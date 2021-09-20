@if ( isset($shippingOptions) && count($shippingOptions) > 0 )

	@foreach ( $shippingOptions as $k => $so )

		<div class="col col-xs-12">
			<label for="{{ $k }}" class="box box-shipping box-choose">
				<input type="radio" name="shipping"
					   data-pristine-required-message="Il campo Spedizione è obbligatorio"
					   @if( isset($shipping) && $shipping && $shipping == $k ) checked @endif
					   value="{{ $k }}" id="{{ $k }}">
				<strong>{{ '€ ' . number_format( $so['amount'], 2, ',', '.' ) }}</strong>
				{{ $so['label'] }}
			</label>
		</div>

	@endforeach

@endif