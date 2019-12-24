<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Kaleidoscope\Factotum\Http\Requests\StoreRole;
use Kaleidoscope\Factotum\Role;

class CreateController extends Controller
{

    public function create(StoreRole $request)
    {
    	$data = $request->all();

        $role = new Role;
        $role->fill($data);
        $role->save();

        return response()->json( [ 'result' => 'ok', 'role'  => $role->toArray() ] );
    }

}
