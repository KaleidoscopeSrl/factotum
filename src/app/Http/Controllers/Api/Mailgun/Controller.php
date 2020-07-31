<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Mailgun;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Kaleidoscope\Factotum\CampaignEmail;

class Controller extends ApiBaseController
{

	protected function _checkSignagure($mgBody)
	{
		if ( isset($mgBody['signature']) ) {
			$signature = hash_hmac('sha256', $mgBody['signature']['timestamp'] . $mgBody['signature']['token'], config('services.mailgun.secret'));
			return ( $signature == $mgBody['signature']['signature'] ? true : false );
		}
		return false;
	}

	protected function _processMailgunEvent(Request $request, $status)
	{
		$mgBody = json_decode( $request->getContent(), true );

		$signResult = $this->_checkSignagure( $mgBody );

		if ( $signResult ) {
			$campaignEmailId = ( isset($mgBody['event-data']['user-variables']['campaign_email_id']) ? $mgBody['event-data']['user-variables']['campaign_email_id'] : null );

			if ( $campaignEmailId ) {
				$campaignEmail = CampaignEmail::find($campaignEmailId);

				if ( $campaignEmail ) {
					$campaignEmail->status = $status;

					if ( $mgBody['event-data']['event'] == 'clicked' ) {
						$clickedUrl = $mgBody['event-data']['url'];
						$logs = date('d/m/Y H:i') .  ' - Clicked on : ' .  $clickedUrl . '<br>' . $campaignEmail->logs;
						$campaignEmail->logs = $logs;
					}

					if ( $mgBody['event-data']['event'] == 'unsubscribed' ) {
						$logs = date('d/m/Y H:i') . ' - Unsubscribed : ' . '<br>' . $campaignEmail->logs;
						$campaignEmail->logs = $logs;
					}

					$campaignEmail->save();
					return true;
				}
			}
		}

		return false;
	}

}
