<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cart extends Model
{
	use SoftDeletes;


	protected $fillable = [
		'customer_id',
		'expires_at',
		'payment_type',
		'paypal_order_id',
		'stripe_intent_id',
		'shipping'
	];



	protected $hidden = [];

	protected $appends = [
		'expired'
	];

	public function customer()
	{
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'customer_id');
	}

	public function products()
	{
		return $this->belongsToMany('Kaleidoscope\Factotum\Product')->withPivot([ 'quantity', 'product_price', 'tax_data' ]);
	}

	// ACCESSORS
	public function getExpiredAttribute()
	{
		return $this->expires_at && strtotime($this->expires_at) < time();
	}

}
