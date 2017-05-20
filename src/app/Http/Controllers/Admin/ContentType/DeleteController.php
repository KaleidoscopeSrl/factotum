<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentType;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;

class DeleteController extends Controller
{
	public function delete($id)
	{
		$contentType = ContentType::find($id);
		$deletedRows = ContentField::where('content_type_id', $id)->delete();
		if ($deletedRows >= 0) {
			$deletedRows = ContentType::destroy($id);
		}
		return redirect('/admin/content-type/list')
					->with('message', Lang::get('factotum::content_type.success_delete_content_type'));
	}
}
