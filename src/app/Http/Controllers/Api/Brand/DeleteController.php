<?php
namespace Kaleidoscope\Factotum\Http\Controllers\Api\Brand;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Brand;

class DeleteController extends Controller
{

    public function remove(Request $request, $id)
    {
        $brand = Brand::find( $id );

        if ( $brand ) {
            $deletedRows = $brand->delete();

            if ( $deletedRows > 0 ) {
                return response()->json( [ 'result' => 'ok' ]);
            }

            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Brand not found', 404 );
    }


	public function removeBrands(Request $request)
	{
		$brands = $request->input('brands');

		if ( $brands && count($brands) > 0 ) {
			Brand::whereIn( 'id', $brands )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
