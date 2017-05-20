<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Category;

class UpdateController extends Controller
{

	public function edit( $id )
	{
		$category = Category::find($id);
		$categories = Category::treeChildsArray( $category->content_type_id, null, $this->currentLanguage, $id );

		return view('admin.category.edit')
					->with('category', $category)
					->with('title', Lang::get('factotum::category.edit_category'))
					->with('postUrl', url('/admin/category/update/' . $id) )
					->with('categoriesTree', $categories);
	}


	public function update(Request $request, $id)
	{
		$data = $request->all();
		$this->validator( $request, $data, $id )->validate();

		$category = Category::find($id);
		$this->_save( $request, $category );

		return redirect('admin/category/list')->with('message', Lang::get('factotum::category.success_update_category'));
	}


	public function sortCategories(Request $request)
	{
		$newOrder = json_decode( $request->input('new_order') );
		if ( count($newOrder) > 0 ) {
			foreach ( $newOrder as $contentFieldID => $order ) {
				$category = Category::find($contentFieldID);
				$category->order_no = $order;
				$category->save();
			}
			return response()->json( [ 'status' => 'ok' ]);
		} else {
			return response()->json( [ 'status' => 'ko' ]);
		}
	}

}
