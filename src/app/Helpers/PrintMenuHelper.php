<?php

namespace Kaleidoscope\Factotum\Helpers;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Models\Content;

class PrintMenuHelper {

	public static function print_menu( $currentLanguage )
	{
		$menu = Content::with('childrenRecursive')
						->whereParentId(null)
						->whereLang($currentLanguage)
						->whereShowInMenu( 1 )
						->orderBy('order_no', 'ASC')
						->get();

		if ( $menu->count() > 0 ) {
			echo self::print_menu_items( $menu );
		}
	}

	private static function print_menu_items( $menu, $level = 0 )
	{
		$html = '';
		$html .= '<ul class="menu-' . $level . '">' . "\n";

		foreach( $menu as $item ) {

			if ( $item->show_in_menu ) {
				$html .= '<li class="menu-item-' . $level . '">' . "\n";
				if ( $item->link != '' ) {

					if ( $item->link_open_in == 'popup' ) {
						$item->link = "window.open('" . $item->link . "', 'popup', 'width=1024,height=768')";
						$html .= '<a href="#" onclick="' . $item->link . '">' . $item->link_title . '</a>' . "\n";
					} else {
						$html .= '<a href="' . $item->link . '" target="' . $item->link_open_in . '">' . $item->link_title . '</a>' . "\n";
					}

				} else {
					$active = false;
					$currUrl  = trim( request()->url(), '/' );
					$checkUrl = trim( $item->abs_url, '/' );
					if ( $currUrl == $checkUrl || ( strstr( $currUrl, $checkUrl) && $checkUrl != url('')) ) {
						$active = true;
					}

					$html .= '<a href="' . $item->abs_url . '"'
						. ($active ? ' class="active"' : '') . '>' . $item->title . '</a>' . "\n";
				}

				if ( $item->childs->count() > 0 ) {
					$level++;
					$html .= self::print_menu_items( $item->childs, $level, true );
				}

				$html .= '</li>' . "\n";
			}

		}

		$html .= '</ul>' . "\n";
		return $html;
	}

}