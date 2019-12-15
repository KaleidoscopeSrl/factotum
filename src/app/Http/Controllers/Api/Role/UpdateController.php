<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Requests\StoreRole;
use Kaleidoscope\Factotum\Role;

class UpdateController extends Controller
{

    public function update(StoreRole $request, $id)
    {
		$data = $request->all();

        $role = Role::find( $id );
		$role->fill($data);
		$role->save();

        return response()->json( [ 'result' => 'ok', 'role'  => $role->toArray() ] );
    }

}
