<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

class Controller extends ApiBaseController
{

	protected $capabilityRules = [
		'content_type_id' => 'required',
		'role_id'         => 'required'
	];


	protected function _validate($request)
	{
		$id = Route::current()->parameter('id');
		$contentTypeId = $request->input('content_type_id');

		if ($contentTypeId) {

			$roleId = $request->input('role_id');

			if ($id) {
				$capability = Capability::where('role_id', $roleId)
					->where('content_type_id', $contentTypeId)
					->first();

				if ($capability && $capability->id != $id) {
					$rules['role_id'] = 'required|unique:capabilities,role_id,NULL,id,content_type_id,' . $contentTypeId;
				} else {
					$rules['role_id'] = 'required';
				}

			} else {

				$this->capabilityRules['role_id'] = 'required|unique:capabilities,role_id,NULL,id,content_type_id,' . $contentTypeId;

			}

		}

		return $this->validate($request, $this->capabilityRules, $this->messages);
	}


	protected function _save(Request $request, $capability)
	{
		$data = $request->all();

		$capability->role_id         = $data['role_id'];
		$capability->content_type_id = $data['content_type_id'];
		$capability->configure       = (isset($data['configure']) && $data['configure'] ? 1 : 0);
		$capability->edit            = (isset($data['edit']) && $data['edit']           ? 1 : 0);
		$capability->publish         = (isset($data['publish']) && $data['publish']     ? 1 : 0);
		$capability->save();

		return $capability;
	}


}
