<?php
namespace Kaleidoscope\Factotum\Http\Controllers\Api\Brand;

use Kaleidoscope\Factotum\Http\Requests\StoreBrand;
use Kaleidoscope\Factotum\Brand;

class UpdateController extends Controller
{

    public function update(StoreBrand $request, $id)
    {
		$data = $request->all();

        $brand = Brand::find( $id );
		$brand->fill($data);
		$brand->save();

        return response()->json( [ 'result' => 'ok', 'brand'  => $brand ] );
    }

}
