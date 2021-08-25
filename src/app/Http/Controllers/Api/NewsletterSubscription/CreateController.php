<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\NewsletterSubscription;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreNewsletterSubscription;
use Kaleidoscope\Factotum\Models\NewsletterSubscription;


class CreateController extends ApiBaseController
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
