<?php

namespace Kaleidoscope\Factotum\Validators;


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
			'email'      => 'required|max:128|email:filter|unique:users,email',
			'phone'      => 'required|max:64',
			'role_id'    => 'required',
		];
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