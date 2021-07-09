<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddress extends Model
{

	use SoftDeletes;


	protected $fillable = [
		'customer_id',
		'type',
		'address',
		'address_line_2',
		'city',
		'zip',
		'province',
		'country',
		'default_address'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	public function customer() {
		return $this->belongsTo('Kaleidoscope\Factotum\Models\User');
	}

}
