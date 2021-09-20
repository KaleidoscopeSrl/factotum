<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ContentType;


class SitemapController extends ApiBaseController
{

	public function generate()
	{
		ini_set('memory_limit', -1);
		ini_set('max_execution_time', 360);

		Artisan::call('factotum:generate-sitemap');

		return response()->json( [ 'result' => 'ok' ]);
	}


	public function savePreference( Request $request )
	{
		$preferencesInput = $request->input('contentTypes');
		$preferences      = [];

		foreach ( $preferencesInput as $key => $value ) {
			if ( $value ) {
				$preferences[] = $key;
			}
		}

		$contentTypes = ContentType::get();

		foreach ( $contentTypes as $contentType ) {

			request()->request->add(['setNoUpdateSchema'=> true]);

			if ( in_array( $contentType->content_type, $preferences ) ) {
				$contentType->sitemap_in = 1;
			} else {
				$contentType->sitemap_in = 0;
			}

			$contentType->save();

		}

		return response()->json( [ 'result' => 'ok', 'contentTypes' => $contentTypes ]);
	}

}
