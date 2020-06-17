<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
	use SoftDeletes;


	protected $fillable = [
		'customer_id',
		'status',

		'phone',

		'delivery_address',
		'delivery_city',
		'delivery_zip',
		'delivery_province',
		'delivery_country',

		'invoice_address',
		'invoice_city',
		'invoice_zip',
		'invoice_province',
		'invoice_country'
	];



	protected $hidden = [
		'deleted_at'
	];


	public function customer() {
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'customer_id');
	}

	public function products() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Product', 'order_product');
	}

	// TODO: email per nuovo ordine ricevuto a backoffice e a client

	// TODO: email per pagamento avvenuto
	public function setTransactionId( $transactionId = '' )
	{
		if ( $transactionId != '' ) {
			$this->transaction_id = $transactionId;
			$this->status         = 'progress';
			$this->save();
		}

		return $this;
	}
}
