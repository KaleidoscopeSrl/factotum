<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentField;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;

class CreateController extends Controller
{

	public function create( $contentTypeId )
	{
		$contentTypes = ContentType::all();

		return view('admin.content_field.edit')
					->with('title', Lang::get('factotum::content_type.add_new_content_type') )
					->with('fieldTypes', $this->fieldTypes)
					->with('imageOperations', $this->imageOperations)
					->with('contentTypes', $contentTypes)
					->with('postUrl', url('/admin/content-field/store/' . $contentTypeId) );
	}

	public function store( $contentTypeId, Request $request )
	{
		$data = $request->all();
		$data['content_type_id'] = $contentTypeId;
		$this->validator($data)->validate();

		$contentField = new ContentField;
		$contentField->content_type_id = $contentTypeId;

		$this->_save( $request, $contentField );

		return redirect('admin/content-field/list')
					->with('message', Lang::get('factotum::content_type.success_create_content_type'));
	}

}
