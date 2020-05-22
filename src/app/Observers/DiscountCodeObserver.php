<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\Request;
use Kaleidoscope\Factotum\DiscountCode;
use Kaleidoscope\Factotum\ProductDiscountCode;

class DiscountCodeObserver
{

	public function saved( DiscountCode $discountCode )
	{
		$products = Request::input('products');

		if ( $products && count($products) > 0 ) {

			// Delete all discount code connected to these products
			ProductDiscountCode::where( 'discount_code_id', $discountCode )->delete();

			foreach ( $products as $prodId ) {
				$prdc = new ProductDiscountCode;
				$prdc->product_id = $prodId;
				$prdc->discount_code_id = $discountCode->id;
				$prdc->save();
			}
		}
	}

}