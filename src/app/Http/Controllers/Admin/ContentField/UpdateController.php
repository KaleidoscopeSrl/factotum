<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentField;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;

class UpdateController extends Controller
{
	public function edit($contentTypeId, $id)
	{
		$contentField = ContentField::find($id);
		$contentTypes = ContentType::all();

		if ( $contentField->options != '' ) {
			$contentField->options = Utility::convertOptionsTextToAssocArray( $contentField->options );
		}
		if ( $contentField->resizes != '' ) {
			$contentField->resizes = Utility::convertOptionsTextToAssocArray( $contentField->resizes );
		}

		return view('factotum::admin.content_field.edit')
					->with('contentField', $contentField)
					->with('title', Lang::get('factotum::content_field.edit_content_field'))
					->with('fieldTypes', $this->fieldTypes)
					->with('imageOperations', $this->imageOperations)
					->with('contentTypes', $contentTypes)
					->with('postUrl', url('/admin/content-field/update/' . $contentTypeId . '/' . $id) );
	}

	public function update(Request $request, $contentTypeId, $id)
	{
		$oldContentField = ContentField::find( $id );

		$data = $request->all();
		$data['content_type_id'] = $contentTypeId;
		$this->validator($data, $id)->validate();

		$contentField = ContentField::find($id);
		$contentField->old_content_field = $oldContentField->name;
		$this->_save( $request, $contentField );

		return redirect('admin/content-field/list')->with('message', Lang::get('factotum::content_field.success_update_content_field'));
	}

	public function sortFields(Request $request)
	{
		$newOrder = json_decode( $request->input('new_order') );
		if ( count($newOrder) > 0 ) {
			foreach ( $newOrder as $contentFieldID => $order ) {
				$contentField = ContentField::find($contentFieldID);
				ContentField::$FIRE_EVENTS = false;
				$contentField->order_no = $order;
				$contentField->save();
			}
			return response()->json( [ 'status' => 'ok' ]);
		} else {
			return response()->json( [ 'status' => 'ko' ]);
		}
	}
}
