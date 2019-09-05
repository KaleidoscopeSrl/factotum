<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Capability;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

class Controller extends ApiBaseController
{
	protected function _save( Request $request, $capability )
	{
		$data = $request->all();

		$capability->role_id         = $data['role_id'];
		$capability->content_type_id = $data['content_type_id'];
		$capability->configure       = (isset($data['configure']) ? 1 : 0);
		$capability->edit            = (isset($data['edit']) ? 1 : 0);
		$capability->publish         = (isset($data['publish']) ? 1 : 0);
		$capability->save();

		return $capability;
	}

	protected function validator(array $data, $id = null)
	{
		$rules = array(
			'content_type_id' => 'required'
		);

		if ($id) {
			$capability = Capability::where('role_id', $data['role_id'])
									 ->where('content_type_id', $data['content_type_id'])
									 ->first();
			if ($capability && $capability->id != $id ) {
				$rules['role_id'] = 'required|unique:capabilities,role_id,NULL,id,content_type_id,' . $data['content_type_id'];
			} else {
				$rules['role_id'] = 'required';
			}
		} else {
			$rules['role_id'] = 'required|unique:capabilities,role_id,NULL,id,content_type_id,' . $data['content_type_id'];
		}

		$this->validationMessages['unique'] = 'Esiste già una capability definita per questo Role e per questo Content Type';
		return Validator::make($data, $rules, $this->validationMessages);
	}
}
