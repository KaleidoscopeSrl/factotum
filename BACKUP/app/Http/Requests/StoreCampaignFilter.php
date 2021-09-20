<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreCampaignFilter extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'filter'        => 'required',
		];

		return $rules;
	}

}
