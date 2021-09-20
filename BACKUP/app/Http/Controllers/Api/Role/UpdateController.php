<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreRole;
use Kaleidoscope\Factotum\Models\Role;


class UpdateController extends ApiBaseController
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
