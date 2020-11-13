<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductVariant;


class ProductVariantObserver
{

	public function saved(ProductVariant $productVariant)
	{
		$allProductVariants = ProductVariant::where( 'product_id', $productVariant->product_id )->get();
		$product = Product::find( $productVariant->product_id );

		$quantity = 0;

		if ( $allProductVariants->count() > 0 ) {
			foreach ( $allProductVariants as $pv ) {
				$quantity += $pv->quantity;
			}

			$product->quantity = $quantity;
			$product->save();
		}
	}

}
