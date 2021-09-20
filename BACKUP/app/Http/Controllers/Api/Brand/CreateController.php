<?php
namespace Kaleidoscope\Factotum\Http\Controllers\Api\Brand;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreBrand;
use Kaleidoscope\Factotum\Models\Brand;


class CreateController extends ApiBaseController
{

    public function create(StoreBrand $request)
    {
    	$data = $request->all();

        $brand = new Brand;
		$brand->fill($data);
		$brand->save();

        return response()->json( [ 'result' => 'ok', 'brand'  => $brand ] );
    }

}
