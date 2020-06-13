<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Illuminate\Support\Facades\App;

use Kaleidoscope\Factotum\Http\Requests\StoreCustomerAddress;
use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;


class ProfileController extends Controller
{

	public function showCustomerAddresses()
	{
		$user              = Auth::user();
		$deliveryAddresses = CustomerAddress::where( 'type', 'delivery' )
											->where( 'customer_id', $user->id )
											->orderBy('default_address', 'DESC')
											->get();

		$invoiceAddress    = CustomerAddress::where( 'type', 'invoice' )->where( 'customer_id', $user->id )->first();


		return view('factotum::ecommerce.user.customer-addresses')
					->with([
						'deliveryAddresses' => $deliveryAddresses,
						'invoiceAddress'    => $invoiceAddress,
						'metatags' => [
							'title'       => Lang::get('factotum::ecommerce_user.customer_addresses_title'),
							'description' => Lang::get('factotum::ecommerce_user.customer_addresses_description')
						]
					]);
	}


	public function showCustomerAddressForm( Request $request, $type, $customerAddressId = '' )
	{
		$user = Auth::user();

		$customerAddress = null;

		if ( $customerAddressId ) {
			$customerAddress = CustomerAddress::where( 'id', $customerAddressId )->where( 'customer_id', $user->id )->first();
		}


		return view('factotum::ecommerce.user.customer-address-form')
					->with([
						'type'    => $type,
						'address' => $customerAddress,
						'metatags' => [
							'title'       => Lang::get('factotum::ecommerce_user.' . ($customerAddress ? 'edit' : 'new' ) . '_customer_address_title'),
							'description' => Lang::get('factotum::ecommerce_user.' . ($customerAddress ? 'edit' : 'new' ) . '_customer_address_description')
						]
					]);
	}


	public function saveCustomerAddress( StoreCustomerAddress $request, $type, $customerAddressId = '' )
	{
		$data = $request->all();
		try {

			$user = Auth::user();

			if ( $user ) {
				if ( $customerAddressId ) {
					$customerAddress = CustomerAddress::where( 'id', $customerAddressId )->where( 'customer_id', $user->id )->first();
				} else {
					$customerAddress = new CustomerAddress;
					$customerAddress->customer_id = $user->id;
					$customerAddress->type        = $type;
				}
	
				$customerAddress->address  = $data['address'];
				$customerAddress->zip      = $data['zip'];
				$customerAddress->city     = $data['city'];
				$customerAddress->province = $data['province'];
				$customerAddress->country  = $data['country'];
				$customerAddress->save();
	
				session()->flash( 'message', Lang::get('factotum::ecommerce_user.customer_address_saved') );
	
				return redirect('/user/customer-addresses');
			}

			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => 'Error on saving customer address' ]) : view('factotum::errors.500');

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');
		}

	}

	public function setDefaultCustomerAddress( Request $request )
	{
		try {
			$user = Auth::user();
			$customerAddressId = $request->input('address_id');

			if ( $user && $customerAddressId ) {
				$customerAddress = CustomerAddress::where( 'id', $customerAddressId )
													->where( 'type', 'delivery' )
													->where( 'customer_id', $user->id )
													->first();

				$customerAddress->default_address = 1;
				$customerAddress->save();

				CustomerAddress::where( 'customer_id', $user->id )
								->where( 'type', 'delivery' )
								->where( 'id', '!=', $customerAddress->id )->update([ 'default_address' => 0 ]);

				$result = [
					'result'          => 'ok',
					'default_address' => true,
					'message'         => 'Indirizzo di default impostato'
				];

				return $request->wantsJson() ? json_encode( $result ) : redirect()->back();
			}

			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => 'Error on setting default address' ]) : view('factotum::errors.500');

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');
		}
	}

}