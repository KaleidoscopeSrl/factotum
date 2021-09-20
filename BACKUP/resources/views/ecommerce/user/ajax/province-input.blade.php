<input id="prov" type="text"
	   class="form-control @error('prov') is-invalid @enderror" name="province"
	   value="{{ old('prov') ? old('prov') : (isset($companyData['prov']) ? $companyData['prov'] : '') }}" required autofocus>
