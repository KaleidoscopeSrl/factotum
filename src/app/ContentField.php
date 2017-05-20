<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class ContentField extends Model
{
	public static $FIRE_EVENTS = true;

	protected $fillable = [
		'content_type_id',
		'name', 'label', 'type', 'mandatory', 'hint',
		'options',
		'max_file_size', 'min_width_size', 'min_height_size', 'image_operation', 'image_bw', 'allowed_types', 'thumb_width', 'thumb_height',
		'linked_content_type_id'
	];

	public function content_type() {
		return $this->belongsTo('Kaleidoscope\Factotum\ContentType');
	}

}
