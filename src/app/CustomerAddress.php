<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{

	protected $fillable = [
		'customer_id',
		'type',
		'address',
		'city',
		'zip',
		'nation',
		'default_address'
	];

	protected $hidden = [
		'created_at', 'updated_at'
	];


	public function customer() {
		return $this->belongsTo('Kaleidoscope\Factotum\User');
	}

}
