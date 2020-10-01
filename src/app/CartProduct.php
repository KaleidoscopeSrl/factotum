<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CartProduct extends Model
{
	protected $table = 'cart_product';

	protected $fillable = [
		'cart_id',
		'product_id',
		'product_variant_id',
		'quantity',
		'tax_data'
	];

	protected $hidden = [
		'deleted_at'
	];


	public function product() {
		return $this->hasOne('Kaleidoscope\Factotum\Product', 'id', 'product_id');
	}

	public function product_variant() {
		return $this->hasOne('Kaleidoscope\Factotum\ProductVariant', 'id', 'product_variant_id');
	}

	public function cart() {
		return $this->hasOne('Kaleidoscope\Factotum\Cart', 'id', 'cart_id');
	}


	// MUTATORS
	public function getTaxDataAttribute($value)
	{
		return ( $value ? json_decode( $value, true ) : null );
	}

}
