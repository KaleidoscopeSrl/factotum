<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class Capability extends Model
{

	protected $fillable = [
		'role_id', 'content_type_id',
		'configure', 'edit', 'publish'
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at'
	];

	public function content_type()
	{
		return $this->belongsTo('Kaleidoscope\Factotum\ContentType');
	}

	public function role()
	{
		return $this->belongsTo('Kaleidoscope\Factotum\Role');
	}
}
