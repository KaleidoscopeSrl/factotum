<?php

$optionsSectionClass = 'hidden';

if ( isset($contentField) &&
	 ( $contentField->type == 'select' || $contentField->type == 'multiselect' ||
	   $contentField->type == 'checkbox' || $contentField->type == 'multicheckbox' ||
	   $contentField->type == 'radio' ) ) {
	$optionsSectionClass = 'visible';
}

if ( old('type') == 'select' || old('type') == 'multiselect' ||
	 old('type') == 'checkbox' || old('type') == 'multicheckbox' ||
	 old('type') == 'radio') {
	$optionsSectionClass = 'visible';
}

?>

<div id="options_section" class="<?php echo $optionsSectionClass; ?>">

	<button class="btn btn-primary" id="add_option">@lang('factotum::content_field.add_option')</button>
	<br><br>
	<div id="options_list" class="sortable_options">

<?php
if ( isset($contentField) && is_array($contentField->options) && count($contentField->options) > 0 ) {

	$index = 0;
	foreach ( $contentField->options as $value => $label) {
?>
			<div class="form-group row clearfix option" data-no="{{ $index }}">
				
				<div class="col-xs-5">
					<input type="text" class="form-control"
						   placeholder="<?php echo Lang::get('factotum::content_field.option_value');?>"
						   name="option_value[]" value="{{ $value }}" autofocus>
				</div>
				<div class="col-xs-4">
					<input type="text" class="form-control"
						   placeholder="<?php echo Lang::get('factotum::content_field.option_label');?>"
						   name="option_label[]" value="{{ $label }}" autofocus>
				</div>
				<div class="col-xs-2">
				<?php if ($index > 0) { ?>
					<button class="remove_option btn btn-danger" value="{{ $index }}">@lang('factotum::generic.remove')</button>
				<?php } ?>
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
