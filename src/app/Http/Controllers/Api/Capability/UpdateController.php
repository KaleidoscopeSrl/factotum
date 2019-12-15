<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Http\Requests\StoreCapability;


class UpdateController extends Controller
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
