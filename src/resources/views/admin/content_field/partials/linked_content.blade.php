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
	<div class="row">
		<!-- Linked Content Type -->
		<div class="col-md-6">
			<?php
			$linkedContentType = new stdClass();
			$linkedContentType->name        = 'linked_content_type_id';
			$linkedContentType->id          = 'field_linked_content_type_id';
			$linkedContentType->label       = Lang::get('factotum::content_field.linked_content_type');
			$linkedContentType->mandatory   = false;
			$linkedContentType->type        = 'select';
			$linkedContentType->show_errors = true;
			$opts = array();
			foreach ($contentTypes as $contentType) {
				$opts[] =  $contentType->id . ':' . $contentType->content_type;
			}
			$linkedContentType->options = join(';', $opts);
			PrintField::print_field( $linkedContentType, $errors, old('linked_content_type_id', (isset($contentField) ? $contentField->linked_content_type_id : null)) );
			?>
		</div>
	</div>
</div>