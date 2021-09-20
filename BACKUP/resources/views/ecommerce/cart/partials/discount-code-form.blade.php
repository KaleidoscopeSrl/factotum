<form class="discount-code-form"
      action="<?php echo ( config('factotum.shop_base_url') ? '/' . config('factotum.shop_base_url') : ''); ?>/cart/apply-discount-code"
	method="post">

	<p class="title">@lang('factotum::ecommerce_cart.discount_code_form_title')</p>

	<div class="field">
		<input type="text" name="discount_code" required
		       @if ( isset($discountCode) && $discountCode )
				value="{{ $discountCode->code }}"
			   @endif
		       placeholder="@lang('factotum::ecommerce_cart.discount_code_form_placeholder')">

		<button type="submit"
		        @if ( isset($discountCode) && $discountCode ) class="hidden" @endif
		        name="apply_discount_code">@lang('factotum::ecommerce_cart.discount_code_form_apply_cta_label')</button>

		<span class="discount_code_applied_response @if ( !isset($discountCode) ) hidden @endif">@lang('factotum::ecommerce_cart.discount_code_valid')</span>
	</div>

	<button class="remove_discount_code @if ( !isset($discountCode) ) hidden @endif">@lang('factotum::ecommerce_cart.discount_code_form_remove_cta_label')</button>

</form>
