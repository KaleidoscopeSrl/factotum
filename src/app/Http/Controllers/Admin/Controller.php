<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use Kaleidoscope\Factotum\User;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $currentLanguage;

	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			$this->currentLanguage = $request->session()->get('currentLanguage');

			View::share( 'availableLanguages', config('factotum.factotum.site_languages') );
			View::share( 'currentLanguage', $this->currentLanguage );

			return $next($request);
		});
	}

	protected function guard()
	{
		return Auth::guard();
	}

	public function index()
	{
		$clientId = (config('factotum.factotum.analytics_client_id') != '' ? config('factotum.factotum.analytics_client_id') : false );
		$siteId   = (config('factotum.factotum.analytics_site_id') != '' ? config('factotum.factotum.analytics_site_id') : false );
		return view('factotum::admin.index')
				->with('clientId', $clientId)
				->with('siteId', $siteId);
	}
}
