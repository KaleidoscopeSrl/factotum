<?php

namespace Kaleidoscope\Factotum\Helpers;

use Kaleidoscope\Factotum\Models\ProductCategory;


class PrintProductCategoriesHelper {

	public static function print_product_categories( $baseURL = '', $productCategory = null, $showChilds = true )
	{
		$productCategories = ProductCategory::with('childrenRecursive')
											->where('parent_id', '=', null)
											->orderBy('label', 'ASC')
											->get();
		
		if ( $productCategories->count() > 0 ) {
			echo self::print_product_categories_items( $productCategories, $baseURL, 0, $productCategory, $showChilds );
		}
	}

	public static function print_product_sub_categories( $baseURL = '', $productCategory, $showChilds = true )
	{
		echo self::print_product_categories_items( $productCategory->childs, $baseURL, 0, null, $showChilds );
	}

	public static function print_filtered_product_categories( $baseURL = '', $filters, $showChilds = true, $brand = null )
	{
		$productCategories = ProductCategory::with('childrenRecursive')
											->where('parent_id', '=', null)
											->orderBy('label', 'ASC')
											->get();

		if ( $productCategories->count() > 0 ) {
			echo self::print_product_categories_items( $productCategories, $baseURL, 0, null, $showChilds, $filters, $brand );
		}
	}

	private static function print_product_categories_items( $productCategories, $baseURL, $level = 0, $productCategory = null, $showChilds = true, $filters = [], $brand = null )
	{
		$html = '';

		$html .= '<ul class="category-' . $level
				. ( $baseURL && strstr( request()->getRequestUri(), $baseURL ) ? ' active' : '')
				. '"><div class="hidden">' . $baseURL . '</div>' . "\n";

		foreach( $productCategories as $item ) {

			if ( isset($filters) && count($filters) > 0 ) {
				if ( !in_array($item->id, $filters ) ) {
					continue;
				}
			}

			if ( $item->total_products == 0 ) {
				continue;
			}

			$active = false;
			if ( strstr(request()->getRequestUri(), $item->name ) ) {
				$active = true;
			}

			$itemUrl = $baseURL . '/' . $item->name;
			if ( isset($brand) && $brand ) {
				$itemUrl .= '?brands=' . $brand->id;
			}

			$html .= '<li class="category-item category-item-' . $level . ( $active ? ' active' : '') .  '">' . "\n";
			$html .= '<div class="flexed">' . "\n";
			$html .= '<a href="' . $itemUrl . '"'
					.' class="' . ( $active ? 'active' : '' ) . '">'
					. ucfirst(strtolower($item->label))
					// . ' (' . $item->total_products . ')'
					. '</a>' . "\n";

			if ( $showChilds && $item->childs->count() > 0 ) {
				$html .= '<button class="toggle-subcategory' . ( $active ? ' active' : '' ) . '"><span class="more">[+]</span><span class="less">[-]</span></button>';
			} else {
				$html .= '<div class="no-button"></div>';
			}

			$html .= '</div>' . "\n";

			if ( $showChilds && $item->childs->count() > 0 ) {
				$level++;
				$html .= self::print_product_categories_items( $item->childs, $baseURL . '/' . $item->name , $level, $productCategory );
			}

			$html .= '</li>' . "\n";

		}

		$html .= '</ul>' . "\n";

		return $html;
	}

}