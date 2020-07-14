<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignTemplate;

use Illuminate\Support\Facades\Mail;

use Kaleidoscope\Factotum\Mail\CampaignEmail;
use Kaleidoscope\Factotum\Http\Requests\PreviewCampaignTemplate;
use Kaleidoscope\Factotum\CampaignTemplate;
use Kaleidoscope\Factotum\User;


class PreviewController extends Controller
{

	public function preview(PreviewCampaignTemplate $request, $id)
	{
		$user             = User::find( $request->input('user_id') );
		$campaignTemplate = CampaignTemplate::find($id);

		if ( !$campaignTemplate ) {
			return $this->_sendJsonError('Template non trovato o non ancora salvato.');
		}

		if ( $user ) {
			Mail::to( $user->email )
				->send( new CampaignEmail( $user, $campaignTemplate ) );

			return response()->json([ 'result' => 'ok' ]);
		}

		return $this->_sendJsonError('Impossibile recuperare la lista di Anteprima.');
	}


}
