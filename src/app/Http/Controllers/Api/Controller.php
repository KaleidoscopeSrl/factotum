<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Kaleidoscope\Factotum\Library\Utility;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $messages = [
		'required'    => 'Il campo :attribute è obbligatorio.',
		'email'       => 'Il campo :attribute non è una email valida',
		'min'         => 'Il campo :attribute deve essere lungo almeno :min caratteri.',
		'max'         => 'Il campo :attribute deve essere lungo al massimo :max caratteri.',
		'exists'      => 'Non esiste nessun utente con questa :attribute.',
		'date_format' => 'Il campo :attribute non è formattato correttamente',
		'unique'      => 'Esiste già un record con questa :attribute.'
	];

	protected $currentLanguage;

	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			$this->currentLanguage = $request->session()->get('currentLanguage');

			View::share( 'availableLanguages', config('factotum.site_languages') );
			View::share( 'currentLanguage', $this->currentLanguage );

			return $next($request);
		});
	}




	protected function guard()
	{
		return Auth::guard();
	}


	protected function _paginationValidation(Request $request)
	{
		$rules = [
			'limit'  => 'required|integer',
			'offset' => 'required|integer',
		];

		return $this->validate( $request, $rules, $this->messages );
	}


	protected function _idValidation(Request $request)
	{
		$rules = [
			'id' => 'required|integer'
		];

		return $this->validate( $request, $rules, $this->messages );
	}

	protected function _searchValidation(Request $request)
	{
		$rules = [
			'search' => 'required|min:3'
		];

		return $this->validate( $request, $rules, $this->messages );
	}


	protected function _sendJsonError( $error, $errorCode = '422' )
	{
		return response()->json( [
			'result'  => 'ko',
			'message' => $error,
			'errors'  => [
				'error' => [ $error ]
			]
		], $errorCode );
	}


	public function optionsRequest( Request $request )
	{
		if ( isset($_SERVER['HTTP_ORIGIN']) ) {
			// ALLOW OPTIONS METHOD
			$headers = [
				'Access-Control-Allow-Origin'      => $_SERVER['HTTP_ORIGIN'],
				'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
				'Access-Control-Allow-Headers'     => 'Accept, Content-Type, Origin, Authorization',
				'Access-Control-Allow-Credentials' => 'true'
			];
		}

		if ( $request->getMethod() === 'OPTIONS' && isset($headers) ) {
			return response('OK', 200, $headers);
		} else {
			return response('OK', 200);
		}
	}

}
