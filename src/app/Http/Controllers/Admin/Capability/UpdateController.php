<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Capability;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\ContentType;

class UpdateController extends Controller
{
	public function edit($id)
	{
		$capability = Capability::find($id);

		$roles = Role::all();
		$contentTypes = ContentType::all();
		return view('factotum::admin.capability.edit')
			->with('title', Lang::get('factotum::capability.edit_capability'))
			->with('postUrl', url('/admin/capability/update/' . $id) )
			->with('capability', $capability)
			->with('roles', $roles)
			->with('contentTypes', $contentTypes);
	}

	public function update(Request $request, $id)
	{
		$this->validator($request->all(), $id)->validate();

		$capability = Capability::find($id);
		$this->_save( $request, $capability );

		return redirect('admin/capability/list')
					->with('message', Lang::get('factotum::capability.success_update_capability'));
	}
}
