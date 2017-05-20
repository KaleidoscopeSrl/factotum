<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
	public function index()
	{
		$contentTypes = ContentType::where('content_type', '<>', 'page')->get();
		if ( $contentTypes->count() > 0 ) {
			foreach ( $contentTypes as $index => $contentType ) {
				$contentType->categories = Category::treeChildsObjects( $contentType->id, null, $this->currentLanguage );
				$contentTypes[$index] = $contentType;
			}
		}

		return view('admin.category.list')
				->with('contentTypesCategories', $contentTypes);
	}

	public function detail($id)
	{
		$contentType = ContentType::find($id);
		echo '<pre>';print_r($contentType->toArray());die;
	}

	public function getContentTypeCategories(Request $request)
	{
		$contentTypeID = $request->input('content_type_id');
		return view('admin.category.get_content_type_categories')
					->with('categoriesTree', Category::treeChildsArray( $contentTypeID, null, $this->currentLanguage ));
	}
}

