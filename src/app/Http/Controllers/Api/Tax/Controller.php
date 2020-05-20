<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tax;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;


class Controller extends ApiBaseController
{

	protected $taxRules = [

	];

	protected function _validate( $request )
	{
		return $this->validate( $request, $this->taxRules, $this->messages );
	}


	protected function _save( $request, $tax )
	{
		$tax->event_id     = $request->input('event_id');
		$tax->name         = $request->input('name');
		$tax->amount       = $request->input('amount');
		$tax->description  = $request->input('description');
		$tax->save();

		return $tax;
	}

}
