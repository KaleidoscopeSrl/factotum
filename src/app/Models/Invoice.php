<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice extends Model
{

	use SoftDeletes;

	protected $fillable = [
		'order_id',
		'number',

		'total_net',
		'total_tax',
		'total_shipping_net',
		'total_shipping_tax',

		'shop_address',
		'notes'
	];

	protected $hidden = [
		'deleted_at'
	];

	protected $appends = [
		'total'
	];

	public function order() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Order', 'id', 'order_id');
	}


	// MUTATORS
	public function getTotalAttribute()
	{
		$total = $this->total_net;
		$total += $this->total_shipping_net;
		$total += $this->total_tax;
		$total += $this->total_shipping_tax;

		return $total;
	}

	public function getTotalNetAttribute($value)
	{
		return (float)$value;
	}

	public function getTotalTaxAttribute($value)
	{
		return (float)$value;
	}

	public function getTotalShippingNetAttribute($value)
	{
		return (float)$value;
	}

	public function getTotalShippingTaxAttribute($value)
	{
		return (float)$value;
	}

	public function getCreatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}

	public function getUpdatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}

}
