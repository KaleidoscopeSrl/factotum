<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Models\Role;


class StoreGuestCustomerInvoiceAddress extends CustomFormRequest
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
			'invoice_address'     => 'required_unless:same_address_as_invoice,true',
			'invoice_zip'         => 'required_unless:same_address_as_invoice,true|max:8',
			'invoice_city'        => 'required_unless:same_address_as_invoice,true',
			'invoice_province'    => 'required_unless:same_address_as_invoice,true',
			'invoice_country'     => 'required_unless:same_address_as_invoice,true|max:2',
		];

		return $rules;
	}

}
