<?php

namespace App\Http\Controllers\Api\DiscountCode;

use Illuminate\Http\Request;

use App\DiscountCode;

class CreateController extends Controller
{

	public function create(Request $request)
	{
		$this->_validate( $request );

		$discountCode = new DiscountCode;
		$discountCode = $this->_save( $request, $discountCode );

		return response()->json( [ 'result' => 'ok', 'discount_code' => $discountCode->toArray() ] );
	}


}
