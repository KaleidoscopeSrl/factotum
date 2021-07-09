<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreDiscountCode;
use Kaleidoscope\Factotum\Models\DiscountCode;


class CreateController extends ApiBaseController
{

	public function create( StoreDiscountCode $request )
	{
		$data = $request->all();

		$discountCode = new DiscountCode;
		$discountCode->fill($data);
		$discountCode->save();

		return response()->json( [ 'result' => 'ok', 'discount_code'  => $discountCode ] );
	}

}
