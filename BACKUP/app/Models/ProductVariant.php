<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductVariant extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'product_id',
		'label',
		'description',
		'quantity',
		'order_no'
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];

	public function products()
	{
		return $this->belongsTo('Kaleidoscope\Factotum\Models\Product');
	}


}
