<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Kaleidoscope\Factotum\Http\Requests\StoreDiscountCode;
use Kaleidoscope\Factotum\DiscountCode;
use Kaleidoscope\Factotum\ProductDiscountCode;

class UpdateController extends Controller
{

	public function update( StoreDiscountCode $request, $id )
	{
		$data = $request->all();

		$products = $data['products'];

		ProductDiscountCode::whereIn('product_id', $products)
							->where('discount_code_id', $id)
							->delete();

		$discountCode = DiscountCode::find($id);
		$discountCode->fill($data);
		$discountCode->save();

		return response()->json( [ 'result' => 'ok', 'discount_code'  => $discountCode ] );
	}

}
