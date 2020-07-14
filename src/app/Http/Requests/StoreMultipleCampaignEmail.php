<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreMultipleCampaignEmail extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'campaign_id' => 'required',
			'users'       => 'required|array',
		];

		return $rules;
	}

}
