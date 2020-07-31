<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CampaignTemplate extends Model
{
	use SoftDeletes;


	protected $fillable = [
		'title',
		'subject',
		'content',
		'design',
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	public function attachments()
	{
		return $this->hasMany('Kaleidoscope\Factotum\CampaignAttachment', 'campaign_template_id', 'id');
	}

}
