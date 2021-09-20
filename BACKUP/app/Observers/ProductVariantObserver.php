<?php

namespace Kaleidoscope\Factotum\Observers;

use Kaleidoscope\Factotum\Models\Product;
use Kaleidoscope\Factotum\Models\ProductVariant;


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
