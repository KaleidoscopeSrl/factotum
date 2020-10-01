<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;


class ProductDiscountCode extends Model
{
	protected $table = 'product_discount_code';

	protected $fillable = [
		'product_id',
		'discount_code_id',
	];


	protected $hidden = [
		'created_at',
		'updated_at',
	];

}
