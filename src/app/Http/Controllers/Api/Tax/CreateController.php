<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tax;

use Kaleidoscope\Factotum\Http\Requests\StoreTax;
use Kaleidoscope\Factotum\Tax;

class CreateController extends Controller
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
