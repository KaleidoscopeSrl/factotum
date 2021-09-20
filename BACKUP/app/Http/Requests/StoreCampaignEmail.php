<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreCampaignEmail extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'user_id'     => 'required',
			'campaign_id' => 'required',
		];

		return $rules;
	}

}
