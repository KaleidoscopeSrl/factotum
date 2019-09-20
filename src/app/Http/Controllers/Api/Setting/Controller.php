<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Content;


class Controller extends ApiBaseController
{

	protected function _validate($request)
	{
		$contentType        = ContentType::where( 'content_type', 'page')->first();
		$availableLanguages = config('factotum.site_languages');
		$rules              = [];

		if ( count($availableLanguages) > 0 ) {

			foreach ($availableLanguages as $lang => $label) {

				$pages = Content::whereNull('parent_id')
								->where( 'content_type_id', $contentType->id)
								->where( 'lang', $lang )
								->count();

				if ( $pages > 0 ) {
					$rules['page_homepage_' . $lang . ''] = 'required';
				}

			}

		}

		return $this->validate($request, $rules, $this->messages);
	}


	public function saveHomepageByLanguage(Request $request)
	{
		$this->_validate($request);

		$contentType        = ContentType::where( 'content_type', 'page')->first();
		$availableLanguages = config('factotum.site_languages');

		if ( count($availableLanguages) > 0 ) {

			foreach ( $availableLanguages as $lang => $label ) {

				if ( $request->input('page_homepage_' . $lang ) ) {

					DB::table('contents')
						->where('content_type_id', $contentType->id)
						->whereLang($lang)
						->update(['is_home' => 0]);

					$contentID = $request->input('page_homepage_' . $lang );
					$content = Content::find($contentID);
					$content->is_home = true;
					$content->save();

				}

			}
		}


		return response()->json(['result' => 'ok']);
	}

}
