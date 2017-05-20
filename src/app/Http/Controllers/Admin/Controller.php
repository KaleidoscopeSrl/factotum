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

	protected $validationMessages = [
		'required'    => 'Il campo :attribute è obbligatorio.',
		'email'       => 'Il campo :attribute non è una email valida',
		'min'         => 'Il campo :attribute deve essere lungo almeno :min caratteri.',
		'max'         => 'Il campo :attribute deve essere lungo al massimo :max caratteri.',
		'exists'      => 'Non esiste nessun utente con questa :attribute.',
		'date_format' => 'Il campo :attribute non è formattato correttamente'
	];

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
		return view('admin.index');
	}
}
