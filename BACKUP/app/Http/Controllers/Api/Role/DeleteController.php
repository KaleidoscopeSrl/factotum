<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;


use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\DeleteRole;
use Kaleidoscope\Factotum\Models\Role;
use Kaleidoscope\Factotum\Models\User;


class DeleteController extends ApiBaseController
{

    public function remove(DeleteRole $request, $id)
    {
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

        return $this->_sendJsonError( 'Role not found', 404 );
    }

}
