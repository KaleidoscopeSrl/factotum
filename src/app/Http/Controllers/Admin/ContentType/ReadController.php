<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentType;

use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
	public function index()
	{
		$contentTypes = ContentType::all();
		return view('factotum::admin.content_type.list')->with('contentTypes', $contentTypes);
	}
}

