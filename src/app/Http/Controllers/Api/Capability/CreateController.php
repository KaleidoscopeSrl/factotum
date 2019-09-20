<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Capability;

class CreateController extends Controller
{

	public function create(Request $request)
	{
		$this->_validate($request);

		$capability = new Capability;
		$capability = $this->_save($request, $capability);

		return response()->json(['result' => 'ok', 'capability' => $capability->toArray()]);
	}

}

