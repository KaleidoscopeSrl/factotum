<?php

namespace Kaleidoscope\Factotum\Helpers;

use Kaleidoscope\Factotum\ProductCategory;

class PrintProductCategoriesHelper {

	public static function print_product_categories( $baseURL = '', $productCategory = null )
	{
		$productCategories = ProductCategory::with('childrenRecursive')
											->where('parent_id', '=', null)
											->get();

		if ( $productCategories->count() > 0 ) {
			echo self::print_product_categories_items( $productCategories, $baseURL, 0, $productCategory );
		}
	}

	private static function print_product_categories_items( $productCategories, $baseURL, $level = 0, $productCategory = null )
	{
		$html = '';
		$html .= '<ul class="category-' . $level . '">' . "\n";

		foreach( $productCategories as $item ) {

			$html .= '<li class="category-item-' . $level . '">' . "\n";
			$html .= '<a href="' . $baseURL . '/' . $item->name . '" class="' . ( $item->id == $productCategory->id ? 'active' : '' ) . '">' . $item->label . '</a>' . "\n";

			if ( $item->childs->count() > 0 ) {
				$level++;
				$html .= self::print_product_categories_items( $item->childs, $baseURL . '/' . $item->name , $level, $productCategory );
			}

			$html .= '</li>' . "\n";

		}

		$html .= '</ul>' . "\n";

		return $html;
	}

}