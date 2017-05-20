<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentField;

use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
	public function index()
	{
		$contentTypes = ContentType::with('content_fields')->get();
		return view('admin.content_field.list')->with('contentTypes', $contentTypes);
	}

	public function detail($id)
	{
		$contentType = ContentType::find($id);
		echo '<pre>';print_r($contentType->toArray());die;
	}
}

