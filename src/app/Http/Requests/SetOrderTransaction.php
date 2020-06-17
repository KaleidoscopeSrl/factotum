<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Kaleidoscope\Factotum\Role;


class SetOrderTransaction extends CustomFormRequest
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
		$rules = [
			'order_id'       => 'required|numeric|exists:orders,id',
			'transaction_id' => 'required'
		];

		return $rules;
	}

}
