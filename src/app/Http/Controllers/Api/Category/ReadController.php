<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\ContentType;

class ReadController extends Controller
{


	public function getList( Request $request, $contentTypeId)
	{

		$categories = Category::where( 'content_type_id', $contentTypeId)
			->orderBy('order_no', 'ASC')
			->get();

		return response()->json( [ 'result' => 'ok', 'categories' => $categories ]);

	}


	public function getListGrouped( Request $request, $contentTypeId)
	{

		$categories = Category::treeChildsObjects( $contentTypeId );

		return response()->json( [ 'result' => 'ok', 'categories' => $categories ]);

	}


	public function getListContentType()
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


}

