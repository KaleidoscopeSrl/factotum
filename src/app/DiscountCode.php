<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DiscountCode extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'code',
		'discount',
		'amount',
		'type',
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
//
//	public function tickets()
//	{
//		return $this->belongsToMany( 'App\Ticket', 'ticket_discount_code' );
//	}


}
