<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;

class UpdateController extends Controller
{
	public function edit($id)
	{
		$contentType = ContentType::find($id);

		return view('factotum::admin.content_type.edit')
					->with('contentType', $contentType)
					->with('title', Lang::get('factotum::content_type.edit_content_type'))
					->with('postUrl', url('/admin/content-type/update/' . $id ) );
	}

	public function update(Request $request, $id)
	{
		$data = $request->all();
		$this->validator( $request, $data, $id )->validate();

		$contentType = ContentType::find($id);
		$oldContentType = $contentType->content_type;
		$contentType->old_content_type = $contentType->content_type;
		$contentType = $this->_save( $request, $contentType );

		return redirect('admin/content-type/list')
					->with('message', Lang::get('factotum::content_type.success_update_content_type'));
	}
}
