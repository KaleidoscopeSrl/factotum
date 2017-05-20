<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Settings;

use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller as MainAdminController;

class Controller extends MainAdminController
{
	protected function validator(array $data)
	{
		$rules = array();
		$availableLanguages = config('factotum.factotum.site_languages');
		if ( count($availableLanguages) > 0 ) {
			foreach ($availableLanguages as $lang => $label) {
				$rules[ 'page_' . $lang . '_homepage' ] = 'required';
			}
		}
		return Validator::make($data, $rules);
	}
}
