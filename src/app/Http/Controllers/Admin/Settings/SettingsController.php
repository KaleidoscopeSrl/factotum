<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Content;

class SettingsController extends Controller
{

	public function create(Request $request)
	{
		$contentType = ContentType::whereContentType('page')->first();

		$availableLanguages = config('factotum.factotum.site_languages');

		$tmp = array();
		if ( count($availableLanguages) > 0 ) {
			foreach ( $availableLanguages as $lang => $label ) {
				$tmp[ $lang ] = Content::whereParentId( null )
										->whereContentTypeId( $contentType->id )
										->whereLang( $lang )
										->get();
			}
		}

		return view('factotum::admin.settings.edit')
					->with('postUrl', url('/admin/settings/store') )
					->with('contents', $tmp);
	}

	public function store(Request $request)
	{
		$this->validator($request->all())->validate();

		$contentType = ContentType::whereContentType('page')->first();

		$availableLanguages = config('factotum.factotum.site_languages');
		if ( count($availableLanguages) > 0 ) {
			foreach ($availableLanguages as $lang => $label) {
				DB::table('contents')
					->where('content_type_id', $contentType->id)
					->whereLang( $lang )
					->update(['is_home' => 0]);

				$contentID = $request->input('page_' . $lang . '_homepage');
				$content = Content::find($contentID);
				$content->is_home = true;
				$content->save();
			}
		}

		return redirect('admin/settings')->with('message', 'Successfully updated settings!');
	}

	public function setLanguage( Request $request, $language )
	{
		$request->session()->put('currentLanguage', $language);
		App::setLocale( $language );

		if ( strstr( url()->previous(), 'edit' ) ) {
			return redirect('admin');
		} else {
			return redirect()->back();
		}
	}
}
