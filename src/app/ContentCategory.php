<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class ContentCategory extends Model
{
	protected $fillable = [
		'content_id', 'category_id'
	];
}
