<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Utility;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;


class Controller extends ApiBaseController
{

	public function getAvailableLanguages()
	{
		return response()->json([
			'result'              => 'ok',
			'available_languages' => config('factotum.site_languages')
		]);
	}


	public function getPagesByLanguage()
	{
		$contentType = ContentType::where( 'content_type', 'page' )->first();
		$languages   = config('factotum.site_languages');
		$tmp         = [];

		foreach ( $languages as $lang => $label ) {

			$tmp[ $lang ] = Content::whereNull( 'parent_id' )
									->where( 'content_type_id', $contentType->id)
									->where( 'lang',            $lang )
									->get();

		}

		return response()->json([
			'result' => 'ok',
			'pages'  => $tmp
		]);
	}


	public function checkSeoKeyword(Request $request)
	{
		$entityId = $request->input('id');
		$keyword   = $request->input('keyword');
		$type      = $request->input('type');

		if ( $keyword ) {

			if ( $type != 'product_category' && $type != 'product' && $type != 'category' ) {
				$query = Content::where( 'seo_focus_key', 'LIKE', '%' . $keyword . '%' );
			} else if ( $type == 'product_category' ) {
				$query = ProductCategory::where( 'seo_focus_key', 'LIKE', '%' . $keyword . '%' );
			} else if ( $type == 'category' ) {
				$query = Category::where( 'seo_focus_key', 'LIKE', '%' . $keyword . '%' );
			} else if ( $type == 'product' ) {
				$query = Product::where( 'seo_focus_key', 'LIKE', '%' . $keyword . '%' );
			}


			if ( $entityId ) {
				$query->where( 'id', '!=', $entityId );
			}

			$occurences = $query->count();

			return response()->json([
				'result'      => 'ok',
				'occurences'  => $occurences
			]);
		}

		return $this->_sendJsonError( 'Keyword not specified' );
	}

}
