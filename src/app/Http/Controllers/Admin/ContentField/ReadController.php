<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentField;

use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
	public function index()
	{
		$contentTypes = ContentType::with(array('content_fields' => function($query) {
			$query->orderBy('order_no', 'ASC');
		}))->get();

		return view('factotum::admin.content_field.list')->with('contentTypes', $contentTypes);
	}
}

