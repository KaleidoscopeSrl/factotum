<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Capability;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\ContentType;

class CreateController extends Controller
{

	public function create()
	{
		$roles = Role::all();
		$contentTypes = ContentType::all();
		return view('admin.capability.edit')
					->with('title', Lang::get('factotum::capability.add_new_capability'))
					->with('postUrl', url('/admin/capability/store') )
					->with('roles', $roles)
					->with('contentTypes', $contentTypes);
	}

	public function store(Request $request)
	{
		$this->validator($request->all())->validate();

		$capability = new Capability;
		$this->_save( $request, $capability );

		return redirect('admin/capability/list')
					->with('message', Lang::get('factotum::capability.success_create_capability'));
	}

}

