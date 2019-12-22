<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Kaleidoscope\Factotum\Library\Utility;

class ContentField extends Model
{
	public static $FIRE_EVENTS = true;

	protected $fillable = [
		'content_type_id',
		'name', 'label', 'type', 'order_no', 'mandatory', 'hint',
		'options',

		'allowed_types',

		'max_file_size',
		'min_width_size',
		'min_height_size',

		'image_operation',
		'image_bw',
		'resizes',


		'linked_content_type_id'
	];

	public function content_type()
	{
		return $this->belongsTo('Kaleidoscope\Factotum\ContentType');
	}


	public function fill( $data )
	{
		if ( isset($data['allowed_types']) && $data['allowed_types'] != '' ) {

			$data['allowed_types'] = Utility::convertOptionsArrayToText( $data['allowed_types'] );

		}

		if ( isset($data['resizes']) && is_array($data['resizes']) && count($data['resizes']) > 0 ) {

			$tmp = [];
			foreach ( $data['resizes'] as $r ) {
				$tmp[] = $r['w'] . ':' . $r['h'];
			}
			$data['resizes'] = Utility::convertOptionsArrayToText( $tmp );

		}

		if ( isset($data['options']) && is_array($data['options']) && count($data['options']) > 0 ) {

			$tmp = [];
			foreach ( $data['options'] as $r ) {
				$tmp[] = $r['value'] . ':' . $r['label'];
			}
			$data['options'] = Utility::convertOptionsArrayToText( $tmp );

		}

		return parent::fill( $data );
	}

}
