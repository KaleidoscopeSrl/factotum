<?php

namespace Kaleidoscope\Factotum\Observers;

use Kaleidoscope\Factotum\Models\ProductCategory;
use Kaleidoscope\Factotum\Models\ProductProductCategory;


class ProductCategoryObserver
{

	public function deleting(ProductCategory $productCategory)
	{
		ProductProductCategory::where( 'product_category_id', $productCategory->id )->delete();
	}

}
