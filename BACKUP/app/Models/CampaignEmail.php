<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CampaignEmail extends Model
{
	use SoftDeletes;


	protected $fillable = [
		'user_id',
		'campaign_id',
		'status'
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	public function campaign()
	{
		return $this->hasOne('Kaleidoscope\Factotum\Models\Campaign', 'id', 'campaign_id');
	}


	public function user()
	{
		return $this->hasOne('Kaleidoscope\Factotum\Models\User', 'id', 'user_id');
	}

}
