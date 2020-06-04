<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller;


class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');

        parent::__construct();
    }

    public function showLinkRequestForm( Request $request )
	{
		// TODO: aggiungere metatags
		return view('factotum::auth.forgot-password');
	}

}
