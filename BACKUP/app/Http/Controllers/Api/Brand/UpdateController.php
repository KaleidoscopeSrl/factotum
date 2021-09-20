<?php
namespace Kaleidoscope\Factotum\Http\Controllers\Api\Brand;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreBrand;
use Kaleidoscope\Factotum\Models\Brand;


class UpdateController extends ApiBaseController
{

    public function update( StoreBrand $request, $id )
    {
		$data = $request->all();

        $brand = Brand::find( $id );
		$brand->fill($data);
		$brand->save();

        return response()->json( [ 'result' => 'ok', 'brand'  => $brand ] );
    }

}
