<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class CategoryContent extends Model
{
	protected $table = 'category_content';

	protected $fillable = [
		'content_id', 'category_id'
	];
}
