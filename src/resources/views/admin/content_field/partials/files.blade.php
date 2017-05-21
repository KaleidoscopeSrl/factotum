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
			<?php
			$fileMaxSize = new stdClass();
			$fileMaxSize->name        = 'max_file_size';
			$fileMaxSize->label       = Lang::get('factotum::content_field.max_size');
			$fileMaxSize->mandatory   = false;
			$fileMaxSize->type        = 'text';
			$fileMaxSize->show_errors = true;
			PrintField::print_field( $fileMaxSize, $errors, old('max_file_size', (isset($contentField) ? $contentField->max_file_size : null)) );
			?>
		</div>
		<div class="col-md-6">
			<!-- Allowed Types -->
			<?php
			$allowedTypes = new stdClass();
			$allowedTypes->name        = 'allowed_types';
			$allowedTypes->label       = Lang::get('factotum::content_field.allowed_types');
			$allowedTypes->mandatory   = false;
			$allowedTypes->type        = 'text';
			$allowedTypes->show_errors = true;
			PrintField::print_field( $allowedTypes, $errors, old('allowed_types', (isset($contentField) ? $contentField->allowed_types : null)) );
			?>
		</div>
	</div>




</div>