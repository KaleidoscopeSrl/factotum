<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Capability;

class ReadController extends Controller
{


	public function getList()
	{
		$capabilities = Capability::with('role')->with('content_type')->get();

		return response()->json(['result' => 'ok', 'capabilities' => $capabilities]);
	}


	public function getDetail(Request $request, $id)
	{
		$capability = Capability::find($id);

		if ( $capability ) {
			return response()->json(['result' => 'ok', 'capability' => $capability]);
		}

		return $this->_sendJsonError('Permesso non trovato.');
	}


}
