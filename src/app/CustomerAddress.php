<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddress extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'customer_id',
		'type',
		'address',
		'city',
		'zip',
		'country',
		'default_address'
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at'
	];


	public function customer() {
		return $this->belongsTo('Kaleidoscope\Factotum\User');
	}

}
