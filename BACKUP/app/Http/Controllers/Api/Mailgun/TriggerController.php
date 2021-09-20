<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Mailgun;

use Illuminate\Http\Request;


class TriggerController extends Controller
{

	public function opened(Request $request)
	{
		$result = parent::_processMailgunEvent($request, 'opened');

		if ( !$result ) {
			return $this->_sendJsonError('Error on Mailgun process event', 406);
		}

		return response()->json( [ 'result' => 'ok' ]);
	}

	public function clicked(Request $request)
	{
		$result = parent::_processMailgunEvent($request, 'clicked');

		if ( !$result ) {
			return $this->_sendJsonError('Error on Mailgun process event', 406);
		}

		return response()->json( [ 'result' => 'ok' ]);
	}

	public function unsubscribed(Request $request)
	{
		$result = parent::_processMailgunEvent($request, 'unsubscribed');

		if ( !$result ) {
			return $this->_sendJsonError('Error on Mailgun process event', 406);
		}

		return response()->json( [ 'result' => 'ok' ]);
	}

}
