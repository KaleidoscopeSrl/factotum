<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CampaignTemplate extends Model
{
	use SoftDeletes;


	protected $fillable = [
		'template_title',
		'subject',
		'title',
		'content',
		'logo',
		'hide_logo',
		'cover'
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	public function campaign_attachments()
	{
		return $this->hasMany('Kaleidoscope\Factotum\CampaignAttachment', 'campaign_template_id', 'id');
	}

}
