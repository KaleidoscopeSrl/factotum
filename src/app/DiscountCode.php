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
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	// RELATIONS
	public function orders()
	{
		return $this->hasMany( 'Kaleidoscope\Factotum\Order', 'discount_code_id' );
	}

	public function customer()
	{
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'customer_id');
	}

}
