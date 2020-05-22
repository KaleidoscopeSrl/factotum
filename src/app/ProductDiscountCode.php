<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductDiscountCode extends Model
{
	use SoftDeletes;

	protected $table = 'product_discount_code';

	protected $fillable = [
		'product_id',
		'discount_code_id',
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];


	// RELATIONS
//	public function tickets()
//	{
//		return $this->belongsToMany( 'App\Ticket', 'ticket_discount_code' );
//	}


}
