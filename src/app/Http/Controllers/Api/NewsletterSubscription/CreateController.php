<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\NewsletterSubscription;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;
use Kaleidoscope\Factotum\Http\Requests\StoreNewsletterSubscription;
use Kaleidoscope\Factotum\NewsletterSubscription;


class CreateController extends Controller
{

	public function create( StoreNewsletterSubscription $request )
	{
		$data = $request->all();

		$newsletterSubscription = new NewsletterSubscription();
		$newsletterSubscription->fill($data);
		$newsletterSubscription->save();

		return response()->json( [ 'result' => 'ok', 'newsletter_subscription'  => $newsletterSubscription ] );
	}

}
