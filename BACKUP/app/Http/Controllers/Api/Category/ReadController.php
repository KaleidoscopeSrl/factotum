<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Category;
use Kaleidoscope\Factotum\Models\ContentType;


class ReadController extends ApiBaseController
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

