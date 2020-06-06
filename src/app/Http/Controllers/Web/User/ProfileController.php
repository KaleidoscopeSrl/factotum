<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\User;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;

use Kaleidoscope\Factotum\Http\Requests\UpdateUser;
use Kaleidoscope\Factotum\Http\Requests\UpdateDeliveryAddress;
use Kaleidoscope\Factotum\Http\Requests\UpdateInvoiceAddress;
use Kaleidoscope\Factotum\Profile;


class ProfileController extends Controller
{

	public function showProfileForm()
	{
		// TODO: aggiungere metatags
		return view('factotum::user.profile')->with( 'user', Auth::user() );
	}


	public function update(UpdateUser $request)
	{
		$data = $request->all();

		$user = Auth::user();
		$user->email = $data['email'];
		if ( $data['password'] != '' ) {
			$user->password = $data['password'];
		}
		$user->save();


		$profile = Profile::where( 'user_id', $user->id )->first();
		$profile->fill( $data );
		$profile->save();

		session()->flash( 'message', 'Profilo aggiornato con successo!' );

		return view('factotum::user.profile')->with( 'user', Auth::user() );
	}


	public function showDeliveryAddressForm()
	{
		// TODO: aggiungere metatags
		return view('factotum::ecommerce.user.delivery-address')->with( 'user', Auth::user() );
	}


	public function saveDeliveryAddress( UpdateDeliveryAddress $request )
	{
		$data = $request->all();

		$user    = Auth::user();
		$profile = Profile::where( 'user_id', $user->id )->first();

		$profile->delivery_address  = $data['delivery_address'];
		$profile->delivery_zip      = $data['delivery_zip'];
		$profile->delivery_city     = $data['delivery_city'];
		$profile->delivery_province = $data['delivery_province'];
		$profile->delivery_nation   = $data['delivery_nation'];

		if ( $data['use_for_invoice'] && $data['use_for_invoice'] == 1 ) {
			$profile->invoice_address  = $data['delivery_address'];
			$profile->invoice_zip      = $data['delivery_zip'];
			$profile->invoice_city     = $data['delivery_city'];
			$profile->invoice_province = $data['delivery_province'];
			$profile->invoice_nation   = $data['delivery_nation'];
		}

		$profile->save();

		session()->flash( 'message', 'Indirizzo di consegna aggiornato con successo!' );

		return view('factotum::ecommerce.user.delivery-address')->with( 'user', Auth::user() );
	}


	public function showInvoiceAddressForm()
	{
		// TODO: aggiungere metatags
		return view('factotum::ecommerce.user.invoice-address')->with( 'user', Auth::user() );
	}


	public function saveInvoiceAddress( UpdateInvoiceAddress $request )
	{
		$data = $request->all();

		$user    = Auth::user();
		$profile = Profile::where( 'user_id', $user->id )->first();

		$profile->invoice_address  = $data['invoice_address'];
		$profile->invoice_zip      = $data['invoice_zip'];
		$profile->invoice_city     = $data['invoice_city'];
		$profile->invoice_province = $data['invoice_province'];
		$profile->invoice_nation   = $data['invoice_nation'];

		if ( $data['use_for_delivery'] && $data['use_for_delivery'] == 1 ) {
			$profile->delivery_address  = $data['invoice_address'];
			$profile->delivery_zip      = $data['invoice_zip'];
			$profile->delivery_city     = $data['invoice_city'];
			$profile->delivery_province = $data['invoice_province'];
			$profile->delivery_nation   = $data['invoice_nation'];
		}

		$profile->save();

		session()->flash( 'message', 'Indirizzo di fatturazione aggiornato con successo!' );

		return view('factotum::ecommerce.user.invoice-address')->with( 'user', Auth::user() );
	}

}
