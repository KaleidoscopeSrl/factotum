<div class="hidden">
	<div class="form-group row clearfix option" id="single_resize_template">
		<div class="col-xs-5">
			<input type="text" class="form-control"
				   placeholder="<?php echo Lang::get('factotum::content_field.width');?>"
				   name="width_resize[]"  autofocus>
		</div>
		<div class="col-xs-4">
			<input type="text" class="form-control"
				   placeholder="<?php echo Lang::get('factotum::content_field.height');?>"
				   name="height_resize[]" autofocus>
		</div>
		<div class="col-xs-2">
			<button class="remove_resize btn btn-danger">@lang('factotum::generic.remove')</button>
		</div>
		<div class="col-xs-1 sort--alt">
			<i class="fa fa-sort"></i>
		</div>
	</div>
</div>

<div class="hidden">
	<div class="form-group row clearfix option" id="single_option_template">
		<div class="col-xs-5">
			<input type="text" class="form-control"
				   placeholder="<?php echo lang::get('factotum::content_field.option_value');?>"
				   name="option_value[]"  autofocus>
		</div>
		<div class="col-xs-4">
			<input type="text" class="form-control"
				   placeholder="<?php echo lang::get('factotum::content_field.option_label');?>"
				   name="option_label[]" autofocus>
		</div>
		<div class="col-xs-2">
			<button class="remove_option btn btn-danger">@lang('factotum::generic.remove')</button>
		</div>
		<div class="col-xs-1 ">
			<i class="fa fa-sort sort--alt"></i>
		</div>
	</div>
</div>