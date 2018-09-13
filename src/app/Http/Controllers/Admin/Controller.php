<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Kaleidoscope\Factotum\Library\Utility;

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

	protected function _parseMedia($media, $fieldName = null)
	{
		if ( $media ) {

			$ext   = strtolower( substr( $media['url'],strlen($media['url'])-4 ) );
			$thumb = substr( $media['url'], 0, strlen($media['url'])-4 ) . '-thumb' . $ext;

			if ( $ext != '.jpg' && $ext != '.png' && $ext != '.gif' ) {
				$thumb = null;
			} else {
				$thumb = url( $thumb );
			}

			$icon  = 'iconfile-' . str_replace('.', '', $ext);

			if ( $media['updated_at'] instanceof Carbon ) {
				$updatedAt = date('d/m/Y H:i', $media['updated_at']->timestamp);
			} else {
				$updatedAt = substr( Utility::convertHumanDateTimeToIso($media['updated_at']), 0 ,16 );
			}

			if ( isset($fieldName) && !is_numeric($fieldName) ) {
				$tmp = array(
					'field_id'   => $fieldName,
					'id'         => $media['id'],
					'url'        => url( $media['url'] ),
					'thumb'      => $thumb,
					'icon'       => $icon,
					'filename'   => $media['filename'],
					'size'       => Utility::formatBytes( Storage::size($media['url']) ),
					'updated_at' => $updatedAt
				);
			} else {
				$tmp = array(
					'id'         => $media['id'],
					'url'        => url( $media['url'] ),
					'thumb'      => $thumb,
					'icon'       => $icon,
					'filename'   => $media['filename'],
					'size'       => Utility::formatBytes( Storage::size($media['url']) ),
					'updated_at' => $updatedAt
				);
			}

			return $tmp;

		}
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
				->with('dashboardAssets', true)
				->with('clientId', $clientId)
				->with('siteId', $siteId);
	}
}
