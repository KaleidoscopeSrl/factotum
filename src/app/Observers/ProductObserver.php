<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\CartProduct;


class ProductObserver
{

	public function deleting(Product $product)
	{
		CartProduct::where('product_id', $product->id)->delete();
	}

}
