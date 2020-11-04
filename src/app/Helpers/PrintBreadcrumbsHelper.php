<?php

namespace Kaleidoscope\Factotum\Helpers;

use Request;

use Kaleidoscope\Factotum\Content;

class PrintBreadcrumbsHelper {

	public static function print_breadcrumbs( $content )
	{
		$page = Content::find( $content->id );
		$pages = $page->getFlatParentsArray();
		$pages = array_reverse( $pages );

		if ( count($pages) > 0 ) {
			echo self::print_breadcrumbs_items( $pages );
		}
	}

	private static function print_breadcrumbs_items( $pages )
	{
		$html = '';
		$html .= '<nav class="breadcrumbs">' . "\n";


		foreach ( $pages as $i => $page ) {

			$active = ($page->abs_url == Request::url() ? true : false );

			$html .= ( $i == count($pages) - 1 ? '<span' : '<a href="' . $page->abs_url . '"' )
					. ($active ? ' class="active"' : '') . '>' . "\n";
			$html .= $page->title . "\n";
			$html .= ( $i == count($pages) - 1 ? '</span>' : '</a>' ) . "\n";
		}

		$html .= '</nav>' . "\n";
		return $html;
	}

}