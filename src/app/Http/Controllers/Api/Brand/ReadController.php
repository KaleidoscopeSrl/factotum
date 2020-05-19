<?php
namespace Kaleidoscope\Factotum\Http\Controllers\Api\Brand;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Brand;


class ReadController extends Controller
{

    public function getList()
    {
        $brands = Brand::orderBy('id','DESC')->get();

        return response()->json( [ 'result' => 'ok', 'brands' => $brands ]);
    }


    public function getListPaginated( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Brand::query();


		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(code) like "%' . $filters['term'] . '%"' );
			}

		}

		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$brands = $query->get();

		return response()->json( [ 'result' => 'ok', 'brands' => $brands ]);
	}


    public function getDetail(Request $request, $id)
    {
		$brand = Brand::find($id);

        if ( $brand ) {
            return response()->json( [ 'result' => 'ok', 'brand' => $brand ]);
        }

        return $this->_sendJsonError( 'Brand not found', 404 );
    }

}
