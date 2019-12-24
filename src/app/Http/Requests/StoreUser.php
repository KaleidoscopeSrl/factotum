<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Kaleidoscope\Factotum\Role;

class StoreUser extends CustomFormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}


	protected function getValidatorInstance()
	{
		$data = $this->all();

		if ( !isset($data['role_id']) ) {
			$subscriberRole  = Role::where( 'role', 'subscriber' )->first();
			$data['role_id'] = $subscriberRole->id;
		}

		if ( !isset($data['password']) ) {
			unset($data['password']);
			unset($data['password_confirmation']);
			$this->request->remove('password');
			$this->request->remove('password_confirmation');
		}

		if ( isset($data['avatar']) && $data['avatar'] == 'null' ) {
			$data['avatar'] = null;
		}

		$this->merge($data);

		return parent::getValidatorInstance();
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = array(
			'first_name'     => 'required|max:64',
			'last_name'      => 'required|max:64',
			'role_id'        => 'required',
			'email'          => 'required|email|max:128|unique:users,email',
		);

		$data = $this->all();

		if ( isset($data['avatar']) && $data['avatar'] != ''
			&& request()->hasFile('avatar') && request()->file('avatar')->isValid() ) {

			$rules['avatar'] = 'required|image';

			if ( substr( $data['avatar'], 0, 10) == 'data:image' ) {
				$rules['avatar'] = 'required';
			}

		}


		$id = request()->route('id');

		if ( $id ) {
			$rules['email'] = 'required|email|max:128|unique:users,id,' . $id;

			if ( isset($data['password']) && $data['password'] != '' ) {
				$rules['password'] = 'required|min:8';
			}
		} else {
			$rules['password'] = 'required|min:8';
			$data['editable'] = true;
		}

		if ( isset($data['password']) && $data['password'] != '' ) {
			$data['password'] = Hash::make($data['password']);
		}

		$this->merge($data);

		return $rules;
	}


}
