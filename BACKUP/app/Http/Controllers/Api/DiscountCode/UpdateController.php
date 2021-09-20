<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreDiscountCode;
use Kaleidoscope\Factotum\Models\DiscountCode;
use Kaleidoscope\Factotum\Models\ProductDiscountCode;


class UpdateController extends ApiBaseController
{

	public function update( StoreDiscountCode $request, $id )
	{
		$data = $request->all();

//		$products = $data['products'];
//
//		ProductDiscountCode::whereIn('product_id', $products)
//							->where('discount_code_id', $id)
//							->delete();

		$discountCode = DiscountCode::find($id);
		$discountCode->fill($data);
		$discountCode->save();

		return response()->json( [ 'result' => 'ok', 'discount_code'  => $discountCode ] );
	}

}
