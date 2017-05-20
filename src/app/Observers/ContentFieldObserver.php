<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;

class ContentFieldObserver
{
	/**
	 * Listen to the ContentType created event.
	 *
	 * @param  ContentType  $contentType
	 * @return void
	 */
	public function created(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$contentType = ContentType::find($contentField->content_type_id);

			// Alter relative table
			Schema::table( $contentType->content_type, function (Blueprint $table)  use ($contentField) {
				if ( $contentField->type == 'text' ||
					$contentField->type == 'select' || $contentField->type == 'multiselect' ||
					$contentField->type == 'checkbox' || $contentField->type == 'multicheckbox' ||
					$contentField->type == 'radio' ||
					$contentField->type == 'file_upload' || $contentField->type == 'image_upload' ||
					$contentField->type == 'multiple_linked_content' ||
					$contentField->type == 'multiple_linked_categories' ) {
					$table->string( $contentField->name, 255 )->nullable( !$contentField->mandatory );
				}

				if ( $contentField->type == 'date' ) {
					$table->date( $contentField->name )->nullable( !$contentField->mandatory );
				}

				if ( $contentField->type == 'datetime' ) {
					$table->dateTime( $contentField->name )->nullable( !$contentField->mandatory );
				}

				if ( $contentField->type == 'textarea' || $contentField->type == 'wysiwyg' ||
					$contentField->type == 'gallery' ) {
					$table->text( $contentField->name, 255 )->nullable( !$contentField->mandatory );
				}

				if ( $contentField->type == 'linked_content' ) {
					$table->integer( $contentField->name )->nullable( !$contentField->mandatory );
				}
			});

			$this->_saveJsonModel( $contentType );
		}
	}

	/**
	 * Listen to the ContentType updated event.
	 *
	 * @param  ContentType  $contentType
	 * @return void
	 */
	public function updating(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$contentType = ContentType::find($contentField->content_type_id);

			$table = null;
			$oldContentField = $contentField->old_content_field;

			// Alter relative table
			Schema::table( $contentType->content_type, function (Blueprint $table)  use ( $oldContentField, $contentField) {
				if ( $oldContentField != '' && $contentField->name != $oldContentField ) {
					$table->renameColumn( $oldContentField, $contentField->name );
				}
			});
		}
	}

	public function updated(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$contentType = ContentType::find($contentField->content_type_id);

			// Alter relative table
			Schema::table( $contentType->content_type, function (Blueprint $table)  use ( $contentField ) {
				if ( $contentField->type == 'text' ||
					$contentField->type == 'select' || $contentField->type == 'multiselect' ||
					$contentField->type == 'checkbox' || $contentField->type == 'multicheckbox' ||
					$contentField->type == 'radio' ||
					$contentField->type == 'file_upload' || $contentField->type == 'image_upload' ||
					$contentField->type == 'multiple_linked_content' ) {
					$table->string( $contentField->name, 255 )->nullable( !$contentField->mandatory )->change();
				}

				if ( $contentField->type == 'date' ) {
					$table->date( $contentField->name )->nullable( !$contentField->mandatory )->change();
				}

				if ( $contentField->type == 'datetime' ) {
					$table->dateTime( $contentField->name )->nullable( !$contentField->mandatory )->change();
				}

				if ( $contentField->type == 'textarea' ||
					$contentField->type == 'wysiwyg' ||
					$contentField->type == 'gallery' ) {
					$table->text( $contentField->name )->nullable( !$contentField->mandatory )->change();
				}

				if ( $contentField->type == 'linked_content' ) {
					$table->integer( $contentField->name )->nullable( !$contentField->mandatory )->change();
				}
			});
			$this->_saveJsonModel( $contentType );
		}
	}


	/**
	 * Listen to the ContentType deleting event.
	 *
	 * @param  ContentType  $contentType
	 * @return void
	 */
	public function deleting(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$contentType  = ContentType::find($contentField->content_type_id);

			// Alter relative table
			Schema::table( $contentType->content_type, function (Blueprint $table)  use ( $contentField ) {
				$table->dropColumn( $contentField->name );
			});
		}
	}

	public function deleted(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$contentType = ContentType::find($contentField->content_type_id);
			$this->_saveJsonModel($contentType);
		}
	}


	private function _saveJsonModel( $contentType )
	{
		$filename = 'models/' . $contentType->content_type . '.json';
		if ( !Storage::disk('local')->exists( $filename ) ) {
			Storage::disk('local')->put( $filename, '' );
		}

		$fields = ContentField::where( 'content_type_id', $contentType->id )->get();
		if ( $fields->count() > 0 ) {
			$obj = array();
			$rel = array();
			foreach ( $fields as $f ) {

				$tmp = array(
					'type' => $f->type
				);

				if ( in_array($f->type, array('image_upload', 'file_upload', 'gallery', 'linked_content', 'multiple_linked_content') )) {
					$tmp['need_parsing'] = true;
				}

				if ( in_array($f->type, array('image_upload', 'gallery') )) {
					$sizes = Utility::convertOptionsTextToAssocArray($f->resizes);

					if ( count($sizes) > 0 ) {
						$tmpSizes = array();
						foreach ( $sizes as $w => $h ) {
							$tmpSizes[] = '-' . $w . 'x' . $h;
						}
						$tmp['sizes'] = $tmpSizes;
					}
				}

				if ( in_array($f->type, array('linked_content', 'multiple_linked_content') )) {
					$tmp['linked_content_type'] = ContentType::find($f->linked_content_type_id)->toArray();
				}

				$obj[ $f->name ] = $tmp;

				if ( $f->type == 'linked_content' || $f->type == 'multiple_linked_content' ) {
					$rel[ $f->name ] = $f->linked_content_type_id;
				}
			}
			Storage::disk('local')->put( $filename, json_encode( array(
				'relations'       => $rel,
				'fields'          => $obj,
				'content_type'    => $contentType->toArray()
			)));
		}
	}
}