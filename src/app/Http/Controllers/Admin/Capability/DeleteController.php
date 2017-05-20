<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Capability;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Capability;

class DeleteController extends Controller
{
	public function delete($id)
	{
		Capability::destroy($id);
		return redirect('/admin/capability/list')
				->with('message', Lang::get('factotum::capability.success_delete_capability'));
	}
}
