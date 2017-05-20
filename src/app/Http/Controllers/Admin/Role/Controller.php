<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller as MainAdminController;

class Controller extends MainAdminController
{
	protected function _save( Request $request, $role )
	{
		$data = $request->all();

		$role->role                 = $data['role'];
		$role->backend_access       = (isset($data['backend_access']) ? 1 : 0);
		$role->manage_content_types = (isset($data['manage_content_types']) ? 1 : 0);
		$role->manage_users         = (isset($data['manage_users']) ? 1 : 0);
		$role->manage_categories    = (isset($data['manage_categories']) ? 1 : 0);
		$role->manage_media         = (isset($data['manage_media']) ? 1 : 0);
		$role->save();

		return $role;
	}

	protected function validator(array $data)
	{
		$rules = array(
			'role' => 'required|max:32',
		);
		return Validator::make($data, $rules);
	}
}
