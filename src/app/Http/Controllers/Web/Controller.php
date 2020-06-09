<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

use Kaleidoscope\Factotum\Traits\CartUtils;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Content;


class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $currentLanguage;
	protected $uri;
	protected $uriParts;
	protected $pageContentType;

	use CartUtils;

	public function __construct()
	{
		$this->pageContentType = ContentType::where( 'content_type', 'page')->first();

		if ( $this->pageContentType ) {
			$this->pageContentType = $this->pageContentType->toArray();
		}

		$this->middleware(function ($request, $next) {

			View::share( 'availableLanguages', config('factotum.site_languages') );

			$this->_setupVariables( $request );

			View::share( 'currentLanguage', $this->_getCurrentLanguage( $request ) );

			$menu = Content::with('childrenRecursive')
							->whereNull( 'parent_id' )
							->where([
								'status'       => 'publish',
								'lang'         => $this->currentLanguage,
								'show_in_menu' => 1,
							])
							->orderBy('order_no', 'ASC')
							->get();

			View::share( 'menu', $menu );

			if ( method_exists( app('App\Http\Controllers\Controller'), 'registerViewShare' ) ) {
				app('App\Http\Controllers\Controller')->registerViewShare();
			}

			return $next($request);
		});
	}


	private function _setupVariables( Request $request )
	{
		$uri       = $request->path();
		$this->uri = trim($uri, '/');

		if ( $this->uri != '' ) {
			$this->uriParts     = explode('/', $this->uri);
			$this->origUriParts = $this->uriParts;
		}
	}

	protected function _getCurrentLanguage( Request $request )
	{
		$checkLang = ( isset($this->uriParts) ? $this->uriParts[0] : '' );

		if ( strlen($checkLang) == 5 && in_array( $checkLang, array_keys( config('factotum.site_languages') ) )  ) {
			$this->currentLanguage = $checkLang;
			App::setLocale( $checkLang );
		} else {
			$this->currentLanguage = config('factotum.main_site_language');
		}

		return $this->currentLanguage;
	}

}
