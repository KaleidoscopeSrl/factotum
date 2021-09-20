<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Models\Role;


class StoreCustomerAddress extends CustomFormRequest
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
			'address'     => 'required',
			'zip'         => 'required|max:7',
			'city'        => 'required',
			'province'    => 'required',
			'country'     => 'required|max:2',
		];

		return $rules;
	}

}
