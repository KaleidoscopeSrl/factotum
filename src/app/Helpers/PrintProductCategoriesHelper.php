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
		$html .= '<ul class="category-' . $level
				. ( $baseURL && strstr( request()->getRequestUri(), $baseURL ) ? ' active' : '')
				. '"><div class="hidden">' . $baseURL . '</div>' . "\n";

		foreach( $productCategories as $item ) {

			$html .= '<li class="category-item category-item-' . $level . '">' . "\n";
			$html .= '<div class="flexed">' . "\n";
			$html .= '<a href="' . $baseURL . '/' . $item->name . '"'
					.' class="' . ( $productCategory && $item->id == $productCategory->id ? 'active' : '' ) . '">' . $item->label . '</a>' . "\n";

			if ( $item->childs->count() > 0 ) {
				$html .= '<button class="toggle-subcategory"><i class="fi flaticon-down-arrow"></i></button>';
			} else {
				$html .= '<div class="no-button"></div>';
			}

			$html .= '</div>' . "\n";

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