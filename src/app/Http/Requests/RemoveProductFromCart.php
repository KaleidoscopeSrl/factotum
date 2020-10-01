<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\Role;


class RemoveProductFromCart extends CustomFormRequest
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
			'product_id' => 'required|numeric|exists:products,id',
			'quantity'   => 'required|numeric|min:1',
		];

		$data = $this->all();

		if ( $data['product_id'] ) {
			$product = Product::find( $data['product_id'] );

			if ( $product->has_variants ) {
				$rules['product_variant_id'] = 'required|numeric|exists:product_variants,id';
			}
		}

		return $rules;
	}

}
