<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreCampaign extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'campaign_template_id' => 'required|exists:campaign_templates,id',
			'title'                => 'required',
		];

		return $rules;
	}

}
