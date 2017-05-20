<?php

$fileSectionClass = 'hidden';

if ( isset($contentField) &&
		($contentField->type == 'file_upload' ||
				$contentField->type == 'image_upload' ||
				$contentField->type == 'gallery') ) {
	$fileSectionClass = 'visible';
}

if ( old('type') == 'file_upload' || old('type') == 'image_upload' || old('type') == 'gallery' ) {
	$fileSectionClass = 'visible';
}

?>
<div id="file_section" class="{{ $fileSectionClass }}">
	<div class="row">
		<div class="col-md-6">
			<!-- File Max Size -->
			<div class="form-group{{ $errors->has('max_file_size') ? ' has-error' : '' }}">
				<div class="col-sm-12">
					<label for="max_file_size" class="control-label">@lang('factotum::content_field.max_size')</label>
					<input id="max_file_size" type="text" class="form-control"
						   name="max_file_size" value="{{ old('max_file_size', (isset($contentField) ? $contentField->max_file_size : null)) }}" autofocus>

					@if ($errors->has('max_file_size'))
						<span class="help-block">
							<strong>{{ $errors->first('max_file_size') }}</strong>
						</span>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<!-- Allowed Types -->
			<div class="form-group{{ $errors->has('allowed_types') ? ' has-error' : '' }}">
				<div class="col-sm-12">
					<label for="allowed_types" class="control-label">@lang('factotum::content_field.allowed_types')</label>
					<input id="allowed_types" type="text" class="form-control"
						   name="allowed_types" value="{{ old('allowed_types', (isset($contentField) ? $contentField->allowed_types : null)) }}" autofocus>

					@if ($errors->has('allowed_types'))
						<span class="help-block">
							<strong>{{ $errors->first('allowed_types') }}</strong>
						</span>
					@endif
				</div>
			</div>
		</div>
	</div>




</div>