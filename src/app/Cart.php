<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cart extends Model
{
	use SoftDeletes;


	protected $fillable = [
		'customer_id',

		'expires_at',
	];



	protected $hidden = [
		'deleted_at'
	];


	public function customer() {
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'customer_id');
	}

}
