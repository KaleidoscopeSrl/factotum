<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreCampaignTemplate extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'template_title'      => 'required',
			'subject'             => 'required',
			'content'             => 'required',
		];

		return $rules;
	}

}
