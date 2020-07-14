<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class CampaignAttachment extends Model
{

	protected $fillable = [
		'campaign_template_id',
		'attachment',
	];


	protected $hidden = [
		'created_at',
		'updated_at'
	];


	public function campaign_template()
	{
		return $this->hasOne('App\CampaignTemplate', 'id', 'campaign_template_id');
	}

}
