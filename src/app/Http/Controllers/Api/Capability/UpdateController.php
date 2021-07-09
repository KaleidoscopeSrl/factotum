<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreCapability;
use Kaleidoscope\Factotum\Models\Capability;



class UpdateController extends ApiBaseController
{

	public function update(StoreCapability $request, $id)
	{
		$data = $request->all();

		$capability = Capability::find($id);
		$capability->fill($data);
		$capability->save();

		return response()->json(['result' => 'ok', 'capability' => $capability->toArray()]);
	}

}
