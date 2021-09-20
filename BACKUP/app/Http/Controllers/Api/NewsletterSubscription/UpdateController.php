<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\NewsletterSubscription;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreNewsletterSubscription;

use Kaleidoscope\Factotum\Models\NewsletterSubscription;


class UpdateController extends ApiBaseController
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
