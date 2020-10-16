<form class="discount-code-form"
      action="<?php echo ( config('factotum.shop_base_url') ? '/' . config('factotum.shop_base_url') : ''); ?>/cart/apply-discount-code"
	method="post">

	<p class="title">@lang('factotum::ecommerce_cart.discount_code_form_title')</p>

	<div class="field">
		<input type="text" name="discount_code" required
		       placeholder="@lang('factotum::ecommerce_cart.discount_code_form_placeholder')">

		<button type="submit"
		        name="apply_discount_code">@lang('factotum::ecommerce_cart.discount_code_form_apply_cta_label')</button>

		<span class="discount_code_applied_response"></span>
	</div>

	<button class="remove_discount_code hidden">@lang('factotum::ecommerce_cart.discount_code_form_remove_cta_label')</button>

</form>