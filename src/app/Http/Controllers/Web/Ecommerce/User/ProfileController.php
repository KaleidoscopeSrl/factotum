<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Requests\StoreCustomerAddress;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;
use Kaleidoscope\Factotum\Models\CustomerAddress;


class ProfileController extends Controller
{

	public function showCustomerAddresses()
	{
		$user              = Auth::user();
		$deliveryAddresses = CustomerAddress::where( 'type', 'delivery' )
											->where( 'customer_id', $user->id )
											->orderBy('default_address', 'DESC')
											->get();

		$invoiceAddresses  = CustomerAddress::where( 'type', 'invoice' )
											->where( 'customer_id', $user->id )
											->orderBy('default_address', 'DESC')
											->get();

		$view = 'factotum::ecommerce.user.customer-addresses';

		if ( file_exists( resource_path('views/ecommerce/user/customer-addresses.blade.php') ) ) {
			$view = 'ecommerce.user.customer-addresses';
		}

		return view($view)
					->with([
						'deliveryAddresses' => $deliveryAddresses,
						'invoiceAddresses'  => $invoiceAddresses,
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

		if ( isset($_GET['back-to-checkout']) ) {
			$request->session()->put('back_to_checkout', 1);
		}

		$view = 'factotum::ecommerce.user.customer-address-form';

		if ( file_exists( resource_path('views/ecommerce/user/customer-address-form.blade.php') ) ) {
			$view = 'ecommerce.user.customer-address-form';
		}

		return view( $view )
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

			if ( config('factotum.guest_cart') ) {
				$userId = $request->session()->get('user_id');
				$user   = User::find($userId);
			} else {
				$user = Auth::user();
			}


			if ( $user ) {
				if ( $customerAddressId ) {
					$customerAddress = CustomerAddress::where( 'id', $customerAddressId )->where( 'customer_id', $user->id )->first();
				} else {
					$customerAddress = new CustomerAddress;
					$customerAddress->customer_id = $user->id;
					$customerAddress->type        = $type;
				}
	
				$customerAddress->address         = $data['address'];
				$customerAddress->address_line_2  = $data['address_line_2'];
				$customerAddress->zip             = $data['zip'];
				$customerAddress->city            = $data['city'];
				$customerAddress->province        = $data['province'];
				$customerAddress->country         = $data['country'];
				$customerAddress->save();
	
				session()->flash( 'message', Lang::get('factotum::ecommerce_user.customer_address_saved') );

				if ( $request->session()->get('back_to_checkout') ) {
					$request->session()->remove('back_to_checkout');
					$request->session()->put( $customerAddress->type . '_address', $customerAddress->id );
					return redirect('/checkout');
				}

				return redirect('/user/customer-addresses');
			}

			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => 'Error on saving customer address' ]) : view($this->_getServerErrorView());

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
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

			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => 'Error on setting default address' ]) : view($this->_getServerErrorView());

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view($this->_getServerErrorView());
		}
	}


	public function getProvinceSelect( Request $request )
	{
		$view = 'factotum::ecommerce.user.ajax.province-select';

		if ( file_exists( resource_path('views/ecommerce/user/province-select.blade.php') ) ) {
			$view = 'ecommerce.user.ajax.province-select';
		}

		return response()->json([
			'result'        => 'ok',
			'html'          => view( $view )->render()
		]);
	}


	public function getProvinceInput( Request $request )
	{
		$view = 'factotum::ecommerce.user.ajax.province-input';

		if ( file_exists( resource_path('views/ecommerce/user/province-input.blade.php') ) ) {
			$view = 'ecommerce.user.ajax.province-input';
		}

		return response()->json([
			'result'        => 'ok',
			'html'          => view( $view )->render()
		]);
	}

}