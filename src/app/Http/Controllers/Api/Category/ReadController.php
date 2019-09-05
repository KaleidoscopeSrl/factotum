<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{
    public function getList()
    {
        $contentTypes = ContentType::where('content_type', '<>', 'page')->get();
        if ( $contentTypes->count() > 0 ) {
            foreach ( $contentTypes as $index => $contentType ) {
                $contentType->categories = Category::treeChildsObjects( $contentType->id );
                $contentTypes[$index] = $contentType;
            }
        }

        return response()->json( [ 'result' => 'ok', 'contentTypes' => $contentTypes ]);
    }

    public function getDetail(Request $request, $id)
    {
        $category = Category::find($id);

        if ( $category ) {
            return response()->json( [ 'result' => 'ok', 'category' => $category ]);
        }

        return $this->_sendJsonError('Categoria non trovata.');
    }

	/*public function getContentTypeCategories(Request $request)
	{
		$contentTypeID = $request->input('content_type_id');
		return view('factotum::admin.category.get_content_type_categories')
					->with('categoriesTree', Category::treeChildsArray( $contentTypeID, null, $this->currentLanguage ));
	}*/
}

