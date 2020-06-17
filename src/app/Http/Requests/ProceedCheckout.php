<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Kaleidoscope\Factotum\Role;


class ProceedCheckout extends CustomFormRequest
{

	public function authorize()
	{
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
		$paymentOptions  = join(',', array_keys( config('factotum.payment_methods') ) );
		$shippingOptions = join(',', array_keys( config('factotum.shipping_options') ) );

		$rules = [
			'delivery-address' => 'required|numeric|exists:customer_addresses,id',
			'invoice-address'  => 'required|numeric|exists:customer_addresses,id',
			'shipping'         => 'required|in:' . $shippingOptions,
			'terms_conditions' => 'required',
			'pay-with'         => 'required|in:' . $paymentOptions,
		];

		return $rules;
	}

}
