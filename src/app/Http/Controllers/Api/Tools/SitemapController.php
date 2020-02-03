<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Kaleidoscope\Factotum\Library\ContentSearch;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Setting;


class SitemapController extends Controller
{

	public function generate()
	{
		$contentTypes = ContentType::where('sitemap_in',1)->get();
		$listData     = [];

		if ( !$contentTypes || $contentTypes->count() == 0 ){
			$homepage               = new ContentType;
			$homepage->abs_url      = url('/').'';
			$homepage->updated_at   = now();
			$listData['default'] = [ $homepage ];
		}

		foreach ($contentTypes as $contentType) {
			$contentSearch = new ContentSearch($contentType->toArray());
			$contentSearch->onlyPublished();
			$listData[$contentType->content_type] = $contentSearch->search()->toArray();
		}
		
		$content = View::make('factotum::frontend.sitemap', ['listData' => $listData]);

		return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');
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

		foreach ( $contentTypes as $contentType ){

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
