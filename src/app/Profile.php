<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

	protected $fillable = [
		'first_name',
		'last_name',
		'user_id'
	];


	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at'
	];


	public function user() {
		return $this->belongsTo('Kaleidoscope\Factotum\User');
	}

}
