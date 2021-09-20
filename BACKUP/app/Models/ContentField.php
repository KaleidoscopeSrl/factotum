<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Kaleidoscope\Factotum\Library\Utility;


class ContentField extends Model
{

	public static $FIRE_EVENTS = true;


	protected $fillable = [
		'content_type_id',
		'name',
		'label',
		'type',
		'order_no',
		'mandatory',
		'readonly',
		'hint',
		'old_content_field',
		'options',

		'allowed_types',

		'max_file_size',
		'min_width_size',
		'min_height_size',

		'image_operation',
		'image_bw',
		'resizes',

		'linked_content_type_id',

		'rules',
	];

	public function content_type()
	{
		return $this->belongsTo('Kaleidoscope\Factotum\Models\ContentType');
	}

	// MUTATORS

	public function getOptionsAttribute($value)
	{
		return ( $value ? json_decode( $value, true ) : null );
	}

	public function getResizesAttribute($value)
	{
		return ( $value ? json_decode( $value, true ) : null );
	}

	public function getAllowedTypesAttribute($value)
	{
		return ( $value ? json_decode( $value, true ) : null );
	}

	public function getRulesAttribute($value)
	{
		return ( $value ? json_decode( $value, true ) : null );
	}


}
