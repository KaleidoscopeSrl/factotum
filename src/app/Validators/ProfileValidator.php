<?php

namespace Kaleidoscope\Factotum\Validators;



/**
 * Class ProfileValidator
 * @package Kaleidoscope\Factotum\Validators
 */
class ProfileValidator extends BaseValidator
{
	/**
	 *
	 */
	protected function validateBasic()
	{
		$this->rules = [
			'first_name' => 'required|max:128',
			'last_name'  => 'required|max:128',
			'phone'      => 'required|max:64',
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

}