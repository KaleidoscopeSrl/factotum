<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Role;


class ReadController extends ApiBaseController
{

    public function getList()
    {
        $roles = Role::orderBy('id','DESC')->get();

        return response()->json( [ 'result' => 'ok', 'roles' => $roles ]);
    }


    public function getDetail(Request $request, $id)
    {
        $role = Role::find($id);

        if ( $role ) {
            return response()->json( [ 'result' => 'ok', 'role' => $role ]);
        }

        return $this->_sendJsonError( 'Role not found', 404 );
    }

}
