<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CustomerAddress;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreCustomerAddress;
use Kaleidoscope\Factotum\Models\CustomerAddress;


class UpdateController extends ApiBaseController
{

	public function update(StoreCustomerAddress $request, $id)
	{
		$data = $request->all();

		$customerAddress = CustomerAddress::find($id);
		$customerAddress->fill( $data );
		$customerAddress->save();

        return response()->json( [ 'result' => 'ok', 'customer_address'  => $customerAddress->toArray() ] );
	}

}
