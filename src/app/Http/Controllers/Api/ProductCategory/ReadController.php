<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\ProductCategory;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ProductCategory;


class ReadController extends ApiBaseController
{


	public function getList( Request $request )
	{
		$productCategories = ProductCategory::orderBy('order_no', 'ASC')->get();

		return response()->json( [ 'result' => 'ok', 'product_categories' => $productCategories ]);
	}


	public function getListGrouped( Request $request )
	{
		$filters = $request->input('filters', null);

		$productCategories = ProductCategory::treeChildsObjects( null, $filters );

		return response()->json( [ 'result' => 'ok', 'product_categories' => $productCategories ]);
	}


	public function getListFlatten( Request $request )
	{
		$filters = $request->input('filters', null);

		$productCategories = ProductCategory::flatTreeChildsArray( null, $filters );

		return response()->json( [ 'result' => 'ok', 'product_categories' => $productCategories ]);
	}


    public function getDetail(Request $request, $id)
    {
        $productCategory = ProductCategory::find($id);

        if ( $productCategory ) {
            return response()->json( [ 'result' => 'ok', 'product_category' => $productCategory ]);
        }

        return $this->_sendJsonError('Categoria Prodotto non trovata.');
    }

}

