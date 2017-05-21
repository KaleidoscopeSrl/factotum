<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentField;

use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
	public function index()
	{
		$contentTypes = ContentType::with('content_fields')->get();
		return view('factotum::admin.content_field.list')->with('contentTypes', $contentTypes);
	}
}

