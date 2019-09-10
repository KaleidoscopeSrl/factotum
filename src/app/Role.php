<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = [
		'role',
		'backend_access',
		'manage_content_types',
		'manage_users',
		'manage_content_categories'
	];

	protected $hidden = [
		'editable',
		'created_at', 'updated_at', 'deleted_at'
	];


	public function user() {
		return $this->belongsTo('Kaleidoscope\Factotum\User');
	}


	public function capabilities() {
		return $this->hasMany('Kaleidoscope\Factotum\Capability');
	}

}
