<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class PreviewCampaignTemplate extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'user_id' => 'required|exists:users,id',
		];

		return $rules;
	}

}
