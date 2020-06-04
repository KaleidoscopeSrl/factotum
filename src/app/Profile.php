<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

	protected $fillable = [
		'first_name',
		'last_name',
		'user_id'
	];

	public function __construct()
	{
		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
			$this->fillable[] = 'phone';
			$this->fillable[] = 'privacy';
			$this->fillable[] = 'newsletter';
			$this->fillable[] = 'partner_offers';
			$this->fillable[] = 'terms_conditions';

			$this->fillable[] = 'delivery_address';
			$this->fillable[] = 'delivery_city';
			$this->fillable[] = 'delivery_zip';
			$this->fillable[] = 'delivery_province';
			$this->fillable[] = 'delivery_nation';

			$this->fillable[] = 'invoice_address';
			$this->fillable[] = 'invoice_city';
			$this->fillable[] = 'invoice_zip';
			$this->fillable[] = 'invoice_province';
			$this->fillable[] = 'invoice_nation';
		}
	}

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at'
	];


	public function user() {
		return $this->belongsTo('Kaleidoscope\Factotum\User');
	}

}
