<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Response;


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
		return $this->belongsTo('Kaleidoscope\Factotum\Product');
	}


}
