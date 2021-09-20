<?php

namespace Kaleidoscope\Factotum\Observers;

use Kaleidoscope\Factotum\Models\Product;
use Kaleidoscope\Factotum\Models\CartProduct;


class ProductObserver
{

	public function deleting(Product $product)
	{
		CartProduct::where('product_id', $product->id)->delete();
	}

}
