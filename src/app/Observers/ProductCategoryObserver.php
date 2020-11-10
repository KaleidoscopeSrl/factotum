<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\ProductProductCategory;


class ProductCategoryObserver
{

	public function deleting(ProductCategory $productCategory)
	{
		ProductProductCategory::where( 'product_category_id', $productCategory->id )->delete();
	}

}
