<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;


class Capability extends Model
{

	// TODO: cambiare spostando nello specifico Module

	protected $fillable = [
		'role_id',
		'configure',
		'edit',
		'publish'
	];


	protected $hidden = [
		'deleted_at'
	];


	public function __construct()
	{
		if ( config('app.FACTOTUM_INSTALLED') ) {
			$this->fillable[] = 'content_type_id';
		}
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function content_type()
	{
		return $this->belongsTo('Kaleidoscope\Factotum\Models\ContentType');
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function role()
	{
		return $this->belongsTo( Role::class );
	}

}
