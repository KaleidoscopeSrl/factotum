<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Role;


class ReadController extends Controller
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

        return $this->_sendJsonError('Ruolo non trovato.');
    }

}
