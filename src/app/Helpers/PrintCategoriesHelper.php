<?php

namespace Kaleidoscope\Factotum\Helpers;

use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Models\Category;


class PrintCategoriesHelper {

	public static function print_categories( $contentType, $baseURL = '' )
	{
		$contentType = ContentType::whereContentType($contentType)->first();

		$categories = Category::with('childrenRecursive')
						->where('parent_id', '=', null)
						->where( 'content_type_id', '=', $contentType->id )->get();

		if ( $categories->count() > 0 ) {
			echo self::print_categories_items( $categories, $baseURL );
		}
	}

	private static function print_categories_items( $categories, $baseURL, $level = 0 )
	{
		$html = '';
		$html .= '<ul class="category-' . $level . '">' . "\n";

		foreach( $categories as $item ) {

			$html .= '<li class="category-item-' . $level . '">' . "\n";
			$html .= '<a href="' . $baseURL . '/' . $item->name . '">' . $item->label . '</a>' . "\n";
			$html .= '</li>' . "\n";

			if ( $item->childs->count() > 0 ) {
				$level++;
				$html .= self::print_categories_items( $item->childs, $baseURL, $level );
			}

		}

		$html .= '</ul>' . "\n";
		return $html;
	}

}