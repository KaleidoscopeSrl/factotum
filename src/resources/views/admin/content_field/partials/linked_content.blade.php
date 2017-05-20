<?php

$linkedContentSectionClass = 'hidden';

if ( isset($contentField) && ($contentField->type == 'linked_content' || $contentField->type == 'multiple_linked_content') ) {
	$linkedContentSectionClass = 'visible';
}

if (old('type') == 'linked_content' || old('type') == 'multiple_linked_content' ) {
	$linkedContentSectionClass = 'visible';
}

?>

<div id="linked_content_section" class="{{ $linkedContentSectionClass }}">
	<!-- Linked Content Type -->
	<div class="col-md-6">
		<div class="form-group{{ $errors->has('linked_content_type_id') ? ' has-error' : '' }}">
			<label for="field_linked_content_type_id" class="control-label">@lang('factotum::content_field.linked_content_type')</label>

			
			<select name="linked_content_type_id" id="field_linked_content_type_id" class="form-control" autofocus>
				@foreach ($contentTypes as $contentType)
					<option value="{{ $contentType->id }}"
					<?php echo ( old('linked_content_type_id', (isset($contentField) ? $contentField->linked_content_type_id : null)) == $contentType->id ? 'selected' : ''); ?>>{{ $contentType->content_type }}</option>
				@endforeach
			</select>

			@if ($errors->has('linked_content_type_id'))
				<span class="help-block">
					<strong>{{ $errors->first('linked_content_type_id') }}</strong>
				</span>
			@endif

		</div>
	</div>
</div>