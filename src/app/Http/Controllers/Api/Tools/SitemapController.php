<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Kaleidoscope\Factotum\Library\ContentSearch;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Setting;

use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Crawler;

class SitemapController extends Controller
{

	public function generate()
	{
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
