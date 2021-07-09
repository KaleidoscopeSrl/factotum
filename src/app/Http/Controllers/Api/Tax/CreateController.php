<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tax;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreTax;
use Kaleidoscope\Factotum\Models\Tax;


class CreateController extends ApiBaseController
{

	public function create( StoreTax $request )
	{
		$data = $request->all();

		$tax = new Tax;
		$tax->fill($data);
		$tax->save();

		return response()->json( [ 'result' => 'ok', 'tax'  => $tax ] );
	}

}
