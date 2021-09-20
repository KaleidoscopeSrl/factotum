<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tax;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreTax;
use Kaleidoscope\Factotum\Models\Tax;


class UpdateController extends ApiBaseController
{

	public function update( StoreTax $request, $id )
	{
		$data = $request->all();

		$tax = Tax::find($id);
		$tax->fill($data);
		$tax->save();

		return response()->json( [ 'result' => 'ok', 'tax'  => $tax ] );
	}

}
