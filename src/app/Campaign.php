<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Campaign extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'title',
		'campaign_template_id',
		'sent_date'
	];

	protected $hidden = [
		'updated_at',
		'deleted_at'
	];

	public function campaign_template()
	{
		return $this->hasOne('Kaleidoscope\Factotum\CampaignTemplate', 'id', 'campaign_template_id');
	}

	public function campaign_emails()
	{
		return $this->hasMany('Kaleidoscope\Factotum\CampaignEmail', 'campaign_id', 'id');
	}

	// MUTATORS
	public function getSentDateAttribute($value)
	{
		return ( $value ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->timestamp : null );
	}
	
	public function getCreatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}

}
