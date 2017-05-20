<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Category;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Category;

class DeleteController extends Controller
{
	public function delete($id)
	{
		Category::destroy($id);
		return redirect( '/admin/category/list/' )
					->with('message', Lang::get('factotum::category.success_delete_category'));
	}
}
