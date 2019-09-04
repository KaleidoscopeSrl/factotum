<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Role;

class UpdateController extends Controller
{
    public function update(Request $request, $id)
    {
        $this->_validate( $request );

        $role = Role::find( $id );
        $role = $this->_save($request, $role);

        return response()->json( [ 'result' => 'ok', 'role'  => $role->toArray() ] );
    }
}
