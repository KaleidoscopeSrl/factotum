<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Models\Content;

class StoreSetting extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$contentType        = ContentType::where( 'content_type', 'page')->first();
		$availableLanguages = config('factotum.site_languages');
		$rules              = [];

		if ( count($availableLanguages) > 0 ) {

			foreach ( $availableLanguages as $lang => $label ) {

				$pages = Content::whereNull('parent_id')
								->where( 'content_type_id', $contentType->id)
								->where( 'lang', $lang )
								->count();

				if ( $pages > 0 ) {
					$rules['page_homepage_' . $lang . ''] = 'required';
				}

			}

		}

		return $rules;
	}


}
