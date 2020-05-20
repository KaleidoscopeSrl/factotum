<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tax;

use Kaleidoscope\Factotum\Http\Requests\StoreTax;
use Kaleidoscope\Factotum\Tax;


class UpdateController extends Controller
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
