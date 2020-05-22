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
		'all_customers'
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	// RELATIONS
//	public function event()
//	{
//		return $this->hasOne('App\Event', 'id', 'event_id');
//	}

	public function products()
	{
		return $this->belongsToMany( 'Kaleidoscope\Factotum\Product', 'product_discount_code' );
	}

}
