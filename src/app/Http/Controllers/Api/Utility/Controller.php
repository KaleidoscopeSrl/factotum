<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Utility;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Content;

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
		$contentType = ContentType::whereContentType('page')->first();
		$languages   = config('factotum.site_languages');
		$tmp         = [];
		foreach ( $languages as $lang => $label ) {

			$tmp[ $lang ] = Content::whereNull('parent_id')
									->where( 'content_type_id', $contentType->id)
									->where( 'lang', $lang )
									->get();

		}

		return response()->json([
			'result'  => 'ok',
			'pages'   => $tmp
		]);

	}

}
