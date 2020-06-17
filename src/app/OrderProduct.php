<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderProduct extends Model
{
	protected $table = 'order_product';

	protected $fillable = [
		'order_id',
		'product_id',
		'quantity',
		'tax_data'
	];


	protected $hidden = [
		'deleted_at'
	];


	public function product() {
		return $this->hasOne('Kaleidoscope\Factotum\Product', 'id', 'product_id');
	}

	public function order() {
		return $this->hasOne('Kaleidoscope\Factotum\Order', 'id', 'order_id');
	}

}
