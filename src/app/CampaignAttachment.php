<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class CampaignAttachment extends Model
{

	protected $fillable = [
		'campaign_template_id',
		'attachment_id',
	];


	protected $hidden = [
		'created_at',
		'updated_at'
	];


	public function campaign_template()
	{
		return $this->hasOne('Kaleidoscope\Factotum\CampaignTemplate', 'id', 'campaign_template_id');
	}

	public function attachment() {
		return $this->hasOne('Kaleidoscope\Factotum\Media', 'id', 'attachment_id');
	}

}
