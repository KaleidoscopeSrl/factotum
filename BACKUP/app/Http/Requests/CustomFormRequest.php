<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CustomFormRequest extends FormRequest
{

	protected function failedValidation(Validator $validator)
	{
		if ( request()->isJson() ) {
			
			$message = 'Errore generico intercettato';
			$errors  = $validator->errors();
			if ( $errors->count() > 0 ) {
				$message = $errors->first();
			}

			$response = [
				'result'  => 'ko',
				'message' => $message,
				'errors'  => $validator->errors(),
				'data'    => request()->all()
			];

			throw new HttpResponseException(response()->json( $response, 422) );
		}

		parent::failedValidation($validator);

		return;
	}

}
