<?php

namespace Kaleidoscope\Factotum\Validators;

use Illuminate\Validation\Rule;


/**
 * Class UserValidator
 * @package Kaleidoscope\Factotum\Validators
 */
class UserValidator extends BaseValidator
{
	/**
	 *
	 */
	protected function validateBasic()
	{
		$this->rules = [
			'first_name' => 'required|max:128',
			'last_name'  => 'required|max:128',
			'email'      => 'required|max:128|email:filter|unique:users,email',
			'phone'      => 'required|max:64',
			'password'   => 'required|min:8',
			'role_id'    => 'required',
		];

		if ( request()->input('avatar') ) {
			$this->rules['avatar'] = 'required';
		}
	}


	/**
	 *
	 */
	protected function validateCreate()
	{
		$this->validateBasic();
	}


	/**
	 *
	 */
	protected function validateUpdate()
	{
		$this->validateBasic();

		$this->rules['email'] = 'required|email|max:128|unique:users,id,' . $this->params['id'];

		if ( !isset($this->data['password']) ) {
			unset($this->rules['password']);
		}
	}

}