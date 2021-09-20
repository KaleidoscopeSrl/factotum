<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Mailgun;

use Illuminate\Http\Request;

class DeliveredController extends Controller
{

	public function delivered(Request $request)
	{
		$result = parent::_processMailgunEvent($request, 'delivered');

		if ( !$result ) {
			return $this->_sendJsonError('Error on Mailgun process event', 406);
		}

		return response()->json( [ 'result' => 'ok' ]);
	}

}
