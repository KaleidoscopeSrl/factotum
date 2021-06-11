<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\NewsletterSubscription;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;
use Kaleidoscope\Factotum\Http\Requests\StoreNewsletterSubscription;
use Kaleidoscope\Factotum\NewsletterSubscription;


class UpdateController extends Controller
{

	public function update( StoreNewsletterSubscription $request, $id )
	{
		$data = $request->all();

		$newsletterSubscription = NewsletterSubscription::find($id);
		$newsletterSubscription->fill($data);
		$newsletterSubscription->save();

		return response()->json( [ 'result' => 'ok', 'newsletter_subscription'  => $newsletterSubscription ] );
	}

}
