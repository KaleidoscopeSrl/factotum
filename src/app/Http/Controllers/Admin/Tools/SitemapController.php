<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Kaleidoscope\Factotum\Library\ContentSearch;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Setting;

class SitemapController extends Controller
{

	public function index()
	{
		$settings = Setting::where('setting_key','sitemap_settings')->first();
		$sitemapSettings = [];
		if ( $settings ){
			$sitemapSettings = json_decode($settings->setting_value);
		} 
		$contentTypes = ContentType::all();
		return view('factotum::admin.tools.sitemap_settings')
					->with( 'title', 'Sitemap Generator' )
					->with( 'listContentType' , $contentTypes )
					->with( 'settings' , $sitemapSettings )
					->with( 'postUrl', url('/admin/tools/save-sitemap-preference/') );
	}

	public function generate()
	{

		$contentTypes = ContentType::all();
		$listData = [];
		//
		$settings = Setting::where('setting_key','sitemap_settings')->first();
		$sitemapSettings = [];
		if ( $settings ){
			$sitemapSettings = json_decode($settings->setting_value);
		} else {
			$homepage = new ContentType;
			$homepage->abs_url      = url('/').'';
			$homepage->updated_at   = now();
			$listData['test'] = $homepage;
		}

		//TODO: come rimuovere pagina come  https://www.kaleidoscope.it/save-contact  ?
		foreach ($contentTypes as $contentType) {
			if ( in_array( $contentType->content_type, $sitemapSettings ) ){
				$tmpType = ContentType::whereContentType($contentType->content_type)->first()->toArray();
				$contentSearch = new ContentSearch($tmpType);
				$contentSearch->onlyPublished();
				$listData[$contentType->content_type] = $contentSearch->search()->toArray();
			}
		}
		
		$content = View::make('factotum::frontend.sitemap', ['listData' => $listData]);
		return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

	}

	public function saveSitemapPreference( Request $request )
	{
		$preferences_input = $request->all();
		$preferences = [];
		foreach ($preferences_input as $key => $value) {
			if (strpos($key, 'contentType') !== false) {
				$preferences[] = $value;
			}
		}
		$settings = Setting::where('setting_key','sitemap_settings')->first();
		if ( $settings ){
			$settings->setting_value = json_encode($preferences);
		} else {
			$settings = new Setting;
			$settings->setting_key   = 'sitemap_settings';
			$settings->setting_value = json_encode($preferences);
		}
		$settings->save();
		return redirect()->back();

	}

}
