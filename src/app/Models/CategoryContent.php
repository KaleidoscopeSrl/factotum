<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryContent extends Model
{

	protected $table = 'category_content';

	protected $fillable = [
		'content_id',
		'category_id'
	];

}
