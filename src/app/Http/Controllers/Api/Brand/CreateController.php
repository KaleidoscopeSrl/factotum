<?php
namespace Kaleidoscope\Factotum\Http\Controllers\Api\Brand;

use Kaleidoscope\Factotum\Http\Requests\StoreBrand;
use Kaleidoscope\Factotum\Brand;

class CreateController extends Controller
{

    public function create(StoreBrand $request)
    {
    	$data = $request->all();

        $brand = new Brand;
		$brand->fill($data);
		$brand->save();

        return response()->json( [ 'result' => 'ok', 'brand'  => $brand->toArray() ] );
    }

}
