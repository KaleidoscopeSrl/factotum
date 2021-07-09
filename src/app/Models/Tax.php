<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tax extends Model
{

	use SoftDeletes;

	protected $fillable = [
		'name',
		'description',
		'amount',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

}
