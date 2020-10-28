<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;


class PimMapping extends Model
{
	public static $FIRE_EVENTS = true;

	protected $table = 'pim_mapping';

	protected $fillable = [
		'lang',
		'pim_id',
		'content_id'
	];

}
