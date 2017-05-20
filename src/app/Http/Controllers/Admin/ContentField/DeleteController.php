<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\ContentField;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\ContentField;

class DeleteController extends Controller
{
	public function delete($id)
	{
		ContentField::destroy($id);
		return redirect('/admin/content-field/list')
				->with('message', Lang::get('factotum::content_field.success_delete_content_field'));
	}
}
