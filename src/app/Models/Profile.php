<?php

namespace Kaleidoscope\Factotum\Models;

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
		}
	}

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at'
	];


	public function user() {
		return $this->belongsTo('Kaleidoscope\Factotum\Models\User');
	}

}
