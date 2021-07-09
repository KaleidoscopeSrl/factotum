<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreCapability;
use Kaleidoscope\Factotum\Models\Capability;


class CreateController extends ApiBaseController
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

