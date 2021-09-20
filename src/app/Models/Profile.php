<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

	protected $fillable = [
		'first_name',
		'last_name',
		'phone',
		'user_id',
		'privacy',
		'newsletter'
	];


	public function __construct()
	{
		if ( config('app.FACTOTUM_ECOMMERCE_INSTALLED') ) {
			$this->fillable[] = 'terms_conditions';
		}
	}

	protected $hidden = [
		'deleted_at'
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( User::class );
	}

}
