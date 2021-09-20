<?php

namespace Kaleidoscope\Factotum\Http\Requests;

class StoreNewsletterSubscription extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'email' => 'required|email|unique:newsletter_subscriptions'
		];

		$id = request()->route('id');

		if ( $id ) {
			$rules['email'] = 'required|email|unique:newsletter_subscriptions,id,' . $id;
		}

		return $rules;
	}

}
