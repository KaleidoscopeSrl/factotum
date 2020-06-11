<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreCustomerAddress;
use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;


class ProfileController extends Controller
{

	public function showCustomerAddresses()
	{
		$user              = Auth::user();
		$deliveryAddresses = CustomerAddress::where( 'type', 'delivery' )->where( 'customer_id', $user->id )->get();
		$invoiceAddress    = CustomerAddress::where( 'type', 'invoice'  )->where( 'customer_id', $user->id )->first();


		// TODO: aggiungere metatags
		return view('factotum::ecommerce.user.customer-addresses')
					->with([
						'deliveryAddresses' => $deliveryAddresses,
						'invoiceAddress'    => $invoiceAddress
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
						'address' => $customerAddress
					]);
	}


	public function saveCustomerAddress( StoreCustomerAddress $request, $type, $customerAddressId = '' )
	{
		$data = $request->all();
		$user = Auth::user();


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
		$customerAddress->nation   = $data['nation'];
		$customerAddress->save();

		session()->flash( 'message', 'Indirizzo salvato con successo!' );

		return redirect('/user/customer-addresses');
	}

}