<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\User;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\User;

class DeleteController extends Controller
{
	// TODO: on delete, reassign all the content to other user
    public function delete($id)
	{
		User::destroy($id);
		return redirect('/admin/user/list')
					->with('message', Lang::get('factotum::user.success_delete_user'));
	}
}
