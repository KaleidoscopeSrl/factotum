<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Models\Role;


class StoreGuestCustomerDeliveryAddress extends CustomFormRequest
{

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
		$rules = [
			'first_name' => 'required',
			'last_name'  => 'required',
			'email'      => 'required|email',
			'phone'      => 'required',

			'delivery_address'     => 'required',
			'delivery_zip'         => 'required|max:8',
			'delivery_city'        => 'required',
			'delivery_province'    => 'required',
			'delivery_country'     => 'required|max:2',
		];

		return $rules;
	}

}
