<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;

class CreateController extends Controller
{

	public function create()
	{
		return view('admin.content_type.edit')
					->with('title', Lang::get('factotum::content_type.add_new_content_type'))
					->with('postUrl', url('/admin/content-type/store') );
	}

	public function store(Request $request)
	{
		$this->validator( $request, $request->all() )->validate();

		$contentType = new ContentType;
		$this->_save( $request, $contentType );

		return redirect('admin/content-type/list')
					->with('message', Lang::get('factotum::content_type.success_create_content_type'));
	}

}
