<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

	protected $fillable = [
		'setting_key',
		'setting_value'
	];

}
