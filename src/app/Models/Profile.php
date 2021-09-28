<?php

namespace Kaleidoscope\Factotum\Models;

use Kaleidoscope\Factotum\Database\Factories\ProfileFactory;


class Profile extends BaseModel
{

	protected static function newFactory()
	{
		return ProfileFactory::new();
	}

	protected $fillable = [
		'user_id',
		'first_name',
		'last_name',
		'phone',
		'privacy',
		'newsletter',
		'terms_conditions'
	];



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
