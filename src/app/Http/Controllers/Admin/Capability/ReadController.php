<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Capability;

use Kaleidoscope\Factotum\Capability;

class ReadController extends Controller
{
	public function index()
	{
		$capabilities = Capability::with('role')->with('content_type')->get();
		return view('factotum::admin.capability.list')->with('capabilities', $capabilities);
	}
}
