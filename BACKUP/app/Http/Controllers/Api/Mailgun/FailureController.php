<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Mailgun;

use Illuminate\Http\Request;

class FailureController extends Controller
{

	public function permamentFailure(Request $request)
	{
		$result = parent::_processMailgunEvent($request, 'permanent_failure');

		if ( !$result ) {
			return $this->_sendJsonError('Error on Mailgun process event', 406);
		}

		return response()->json( [ 'result' => 'ok' ]);
	}

	public function temporaryFailure(Request $request)
	{
		$result = parent::_processMailgunEvent($request, 'temporary_failure');

		if ( !$result ) {
			return $this->_sendJsonError('Error on Mailgun process event', 406);
		}

		return response()->json( [ 'result' => 'ok' ]);
	}

	public function complained(Request $request)
	{
		$result = parent::_processMailgunEvent($request, 'complained');

		if ( !$result ) {
			return $this->_sendJsonError('Error on Mailgun process event', 406);
		}

		return response()->json( [ 'result' => 'ok' ]);
	}

}
