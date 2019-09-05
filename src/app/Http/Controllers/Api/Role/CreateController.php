<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Role;

class CreateController extends Controller
{

    public function create(Request $request)
    {
        $this->_validate( $request );

        $role = new Role;
        $role = $this->_save( $request, $role );

        return response()->json( [ 'result' => 'ok', 'role'  => $role->toArray() ] );
    }

}
