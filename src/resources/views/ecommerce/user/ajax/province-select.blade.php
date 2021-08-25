<select name="province" id="prov" required>
	<option value="">Seleziona la provincia</option>
	@foreach ( \Kaleidoscope\Factotum\Library\Utility::getProvinceList() as $code => $label )
		<option value="{{ $code }}" @if( (old('prov') && old('prov') == $code) || ( isset($address) && $address->province == $code ) ) selected @endif>{{ $label }}</option>
	@endforeach
</select>
