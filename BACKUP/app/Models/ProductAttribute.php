<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;


class ProductAttribute extends Model
{

	protected $fillable = [
		'name',
		'label',
		'visible',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];

	public function values()
	{
		return $this->hasMany('Kaleidoscope\Factotum\Models\ProductAttributeValue');
	}


}
