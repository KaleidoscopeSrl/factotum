<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CustomerAddress;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreCustomerAddress;
use Kaleidoscope\Factotum\CustomerAddress;


class UpdateController extends Controller
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
