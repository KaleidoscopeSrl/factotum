<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;


class SetShipping extends CustomFormRequest
{
	use EcommerceUtils;

	public function authorize()
	{
		if ( config('factotum.guest_cart') ) {
			return true;
		}

		$user = Auth::user();

		$roleCustomer = Role::where('role', 'customer')->first();
		$roleAdmin    = Role::where('role', 'admin')->first();

		if ( $user ) {
			if ( $user->role_id == $roleCustomer->id || $user->role_id == $roleAdmin->id ) {
				return true;
			}
		}

		return false;
	}


	public function rules()
	{
		$opts = array_keys( $this->_getShippingOptions() );

		if ( config('factotum.min_free_shipping') ) {
			$opts[] = 'free';
		}

		$shippingOptions = join(',', $opts );

		$rules = [
			'shipping' => 'required|in:' . $shippingOptions,
		];

		return $rules;
	}

}
