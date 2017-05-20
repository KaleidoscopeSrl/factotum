<?php

$imageSectionClass = 'hidden';

if ( isset($contentField) &&
		($contentField->type == 'image_upload' ||
				$contentField->type == 'gallery') ) {
	$imageSectionClass = 'visible';
}

if (old('type') == 'image_upload' || old('type') == 'gallery' ) {
	$imageSectionClass = 'visible';
}

?>

<div id="image_section" class="{{ $imageSectionClass }}">
	<div class="row">
		<div class="col-md-6">
			<!-- Image Max Width Size -->
			<div class="form-group{{ $errors->has('min_width_size') ? ' has-error' : '' }}">
				<div class="col-sm-12">
					<label for="min_width_size" class="control-label">@lang('factotum::content_field.min_width')</label>
					<input id="min_width_size" type="text" class="form-control"
						   name="min_width_size" value="{{ old('min_width_size', (isset($contentField) ? $contentField->min_width_size : null)) }}" autofocus>

					@if ($errors->has('min_width_size'))
						<span class="help-block">
							<strong>{{ $errors->first('min_width_size') }}</strong>
						</span>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<!-- Image Max Height Size -->
			<div class="form-group{{ $errors->has('min_height_size') ? ' has-error' : '' }}">
				<div class="col-sm-12">
					<label for="max_height_size" class="control-label">@lang('factotum::content_field.min_height')</label>
					<input id="min_height_size" type="text" class="form-control"
						   name="min_height_size" value="{{ old('min_height_size', (isset($contentField) ? $contentField->min_height_size : null)) }}" autofocus>

					@if ($errors->has('min_height_size'))
						<span class="help-block">
							<strong>{{ $errors->first('min_height_size') }}</strong>
						</span>
					@endif
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<!-- Image Operation -->
			<div class="form-group{{ $errors->has('image_operation') ? ' has-error' : '' }}">
				<div class="col-sm-12">
					<label for="field_image_operation" class="control-label">@lang('factotum::content_field.image_operation')</label>
					<div class="select-wrapper">
						<select name="image_operation" id="field_image_operation" class="form-control" required autofocus>
							@foreach ($imageOperations as $imageOp => $imageOpLabel)
								<option value="{{ $imageOp }}"
								<?php echo ( old('image_operation', (isset($contentField) ? $contentField->image_operation : null)) == $imageOp ? 'selected' : ''); ?>>{{ $imageOpLabel }}</option>
							@endforeach
						</select>
					</div>

					@if ($errors->has('image_operation'))
						<span class="help-block">
							<strong>{{ $errors->first('image_operation') }}</strong>
						</span>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<!-- Image B/W -->
			<div class="form-group{{ $errors->has('image_bw') ? ' has-error' : '' }}">
				<div class="col-sm-12">
					<label for="image_bw" class="control-label">
					<div class="form-control" style="border: none; box-shadow: none;">
						<div class="checkbox">
							<label for="remember" class="control-label mt">
								<input type="checkbox" id="image_bw"
								name="image_bw" value="1"
								<?php echo (isset($contentField) && $contentField->image_bw ? ' checked' : ''); ?>>
								<span class="checkbox-material"><span class="check"></span></span> @lang('factotum::content_field.black_white')
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="resizes_section" class="sortable_resizes">
		<button class="btn btn-primary" id="add_resize">@lang('factotum::content_field.add_resize')</button>
		<br><br>
		<div id="resize_list">

<?php
if ( isset($contentField) && is_array($contentField->resizes) && count($contentField->resizes) > 0 ) {

	$index = 0;
	foreach ( $contentField->resizes as $width => $height ) {
?>
			<div class="form-group row clearfix resize" data-no="{{ $index }}">
				<div class="col-xs-5">
					<input type="text" class="form-control"
						   placeholder="<?php echo Lang::get('factotum::content_field.width');?>"
						   name="width_resize[]" value="{{ $width }}" autofocus>
				</div>
				<div class="col-xs-4">
					<input type="text" class="form-control"
						   placeholder="<?php echo Lang::get('factotum::content_field.height');?>"
						   name="height_resize[]" value="{{ $height }}" autofocus>
				</div>
				<div class="col-xs-2">
					<button class="remove_resize btn btn-danger" value="{{ $index }}">@lang('factotum::generic.remove')</button>
				</div>
				<div class="col-xs-1">
					<i class="fa fa-sort sort--alt"></i>
				</div> 
			</div>

<?php
		$index++;
	}
}
?>

		</div>
	</div>

</div>

