<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\User;

class DeleteController extends Controller
{

    public function remove(Request $request, $id)
    {

        $this->validate($request, $this->deleteRoleRules, $this->messages);

        $reassigningRole = $request->input('reassigned_role');

        User::where('role_id', $id)
            ->update(['role_id' => $reassigningRole]);


        $role = Role::find( $id );

        if ( $role ) {
            $deletedRows = $role->delete();

            if ( $deletedRows > 0 ) {
                return response()->json( [ 'result' => 'ok' ]);
            }
            return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
        }

        return $this->_sendJsonError( 'Ruolo non trovato.' );
    }

}
