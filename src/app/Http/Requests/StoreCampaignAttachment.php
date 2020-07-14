<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreCampaignAttachment extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'files'    => 'required',
		];

		return $rules;
	}

}
