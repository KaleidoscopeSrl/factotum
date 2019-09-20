<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\ContentType;

class UpdateController extends Controller
{

	public function update(Request $request, $id)
	{
		$this->_validate($request);

		$capability = Capability::find($id);
		$capability = $this->_save($request, $capability);

		return response()->json(['result' => 'ok', 'capability' => $capability->toArray()]);
	}

}
