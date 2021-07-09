<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CustomerAddress;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreCustomerAddress;
use Kaleidoscope\Factotum\Models\CustomerAddress;


class CreateController extends ApiBaseController
{

	public function create(StoreCustomerAddress $request)
	{
		$data = $request->all();

		$customerAddress = new CustomerAddress;
		$customerAddress->fill( $data );
		$customerAddress->save();

		return response()->json( [ 'result' => 'ok', 'customer_address'  => $customerAddress->toArray() ] );
	}

}
