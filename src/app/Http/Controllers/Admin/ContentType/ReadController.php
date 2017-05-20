<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentType;

use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
	public function index()
	{
		$contentTypes = ContentType::all();
		return view('admin.content_type.list')->with('contentTypes', $contentTypes);
	}

	public function detail($id)
	{
		$contentType = ContentType::find($id);
		echo '<pre>';print_r($contentType->toArray());die;
	}
}

