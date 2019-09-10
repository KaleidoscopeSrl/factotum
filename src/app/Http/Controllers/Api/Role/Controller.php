<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

class Controller extends ApiBaseController
{

    protected $roleRules = [
        'role' => 'required|max:32|unique:roles',
    ];

    protected $deleteRoleRules = [
        'reassigned_role' => 'required',
    ];


    protected function _validate( $request )
    {
        return $this->validate($request, $this->roleRules, $this->messages);
    }


	protected function _save( Request $request, $role )
	{
		$data = $request->all();

		$role->role                 = $data['role'];
		$role->backend_access       = (isset($data['backend_access']) && $data['backend_access']             ? 1 : 0);
		$role->manage_content_types = (isset($data['manage_content_types']) && $data['manage_content_types'] ? 1 : 0);
		$role->manage_users         = (isset($data['manage_users']) && $data['manage_users']                 ? 1 : 0);
		$role->manage_categories    = (isset($data['manage_categories']) && $data['manage_categories']       ? 1 : 0);
		$role->manage_media         = (isset($data['manage_media']) && $data['manage_media']                 ? 1 : 0);
		$role->manage_settings      = (isset($data['manage_settings']) && $data['manage_settings']           ? 1 : 0);
		$role->save();

		return $role;
	}


}
