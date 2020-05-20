<?php

namespace App\Http\Controllers\Api\DiscountCode;

use Illuminate\Http\Request;

use App\DiscountCode;

class UpdateController extends Controller
{

	public function update(Request $request, $id)
	{
		$this->_validate( $request );

		$discountCode = DiscountCode::find($id);
		$discountCode = $this->_save($request, $discountCode);

		return response()->json( [ 'result' => 'ok', 'discount_code' => $discountCode->toArray() ] );
	}


}
