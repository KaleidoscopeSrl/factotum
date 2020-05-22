<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Kaleidoscope\Factotum\Http\Requests\StoreDiscountCode;
use Kaleidoscope\Factotum\DiscountCode;


class UpdateController extends Controller
{

	public function update( StoreDiscountCode $request, $id )
	{
		$data = $request->all();

		$discountCode = DiscountCode::find($id);
		$discountCode->fill($data);
		$discountCode->save();

		return response()->json( [ 'result' => 'ok', 'discount_code'  => $discountCode ] );
	}

}
