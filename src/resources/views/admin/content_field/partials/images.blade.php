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
			<!-- Image Min Width Size -->
			<?php
			$imageMinWidth = new stdClass();
			$imageMinWidth->name        = 'min_width_size';
			$imageMinWidth->label       = Lang::get('factotum::content_field.min_width');
			$imageMinWidth->mandatory   = false;
			$imageMinWidth->type        = 'text';
			$imageMinWidth->show_errors = true;
			PrintField::print_field( $imageMinWidth, $errors, old('min_width_size', (isset($contentField) ? $contentField->min_width_size : null)) );
			?>
		</div>
		<div class="col-md-6">
			<!-- Image Max Height Size -->
			<?php
			$imageMinHeight = new stdClass();
			$imageMinHeight->name        = 'min_height_size';
			$imageMinHeight->label       = Lang::get('factotum::content_field.min_height');
			$imageMinHeight->mandatory   = false;
			$imageMinHeight->type        = 'text';
			$imageMinHeight->show_errors = true;
			PrintField::print_field( $imageMinHeight, $errors, old('min_height_size', (isset($contentField) ? $contentField->min_height_size : null)) );
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<!-- Image Operation -->
			<?php
			$imageOperation = new stdClass();
			$imageOperation->name        = 'image_operation';
			$imageOperation->id          = 'field_image_operation';
			$imageOperation->label       = Lang::get('factotum::content_field.image_operation');
			$imageOperation->mandatory   = true;
			$imageOperation->type        = 'select';
			$imageOperation->show_errors = true;
			$opts = array();
			foreach ($imageOperations as $ind => $lab) {
				$opts[] =  $ind . ':' . $lab;
			}
			$imageOperation->options = join(';', $opts);
			PrintField::print_field( $imageOperation, $errors, old('image_operation', (isset($contentField) ? $contentField->image_operation : null)) );
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<!-- Image B/W -->
			<?php
			$imageBW = new stdClass();
			$imageBW->label       = ' ';
			$imageBW->name        = 'image_bw';
			$imageBW->mandatory   = false;
			$imageBW->type        = 'checkbox';
			$imageBW->show_errors = true;
			$imageBW->options     = '1:' . Lang::get('factotum::content_field.black_white');
			PrintField::print_field( $imageBW, $errors, isset($contentField) ? $contentField->image_bw : null );
			?>
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

