<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Category;

class CreateController extends Controller
{
	public function create( $contentTypeId )
	{
		$categories = Category::treeChildsArray( $contentTypeId, null, $this->currentLanguage );

		return view('admin.category.edit')
					->with('title', Lang::get('factotum::category.add_new_category') )
					->with('postUrl', url('/admin/category/store/' . $contentTypeId) )
					->with('categoriesTree', $categories);
	}

	public function store( $contentTypeId, Request $request )
	{
		$data = $request->all();
		$data['content_type_id'] = $contentTypeId;
		$this->validator( $request, $data )->validate();

		$category = new Category;
		$category->content_type_id = $contentTypeId;

		$this->_save( $request, $category );

		return redirect( 'admin/category/list/' )
					->with('message', Lang::get('factotum::category.success_create_category'));
	}

}