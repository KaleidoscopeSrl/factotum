<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use ProductDiscountCode;

class DiscountCode extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'code',
		'discount',
		'amount',
		'type',
		'customer_id',
		'all_customers',
		'brand_id',
		'fiscal_code'
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	// RELATIONS
	public function products()
	{
		return $this->belongsToMany( 'Kaleidoscope\Factotum\Product', 'product_discount_code' );
	}

	public function customer()
	{
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'customer_id');
	}

}
