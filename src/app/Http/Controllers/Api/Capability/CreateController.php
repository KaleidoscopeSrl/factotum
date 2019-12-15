<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Http\Requests\StoreCapability;

class CreateController extends Controller
{

	public function create(StoreCapability $request)
	{
		$data = $request->all();

		$capability = new Capability;
		$capability->fill($data);
		$capability->save();

		return response()->json(['result' => 'ok', 'capability' => $capability->toArray()]);
	}

}

