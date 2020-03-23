<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;


class ContentFieldObserver
{

	private function _getColumnType( $type )
	{
		switch ( $type ) {
			case 'text':
			case 'email':
			case 'url':
			case 'number':
			case 'select':
			case 'multiselect':
			case 'checkbox':
			case 'radio':
			case 'file_upload':
			case 'image_upload':
			case 'multiple_linked_content':
				return 'VARCHAR(255)';
			break;

			case 'date':
				return 'DATE';
			break;

			case 'time':
				return 'VARCHAR(5)';
			break;

			case 'datetime':
				return 'TIMESTAMP';
			break;

			case 'textarea':
			case 'wysiwyg':
			case 'gallery':
				return 'TEXT';
			break;

			case 'linked_content':
				return 'INT(11)';
			break;
		}
	}


	private function _setColumnField( $contentField, $update = false )
	{
		$contentType = ContentType::find($contentField->content_type_id);

		$query = 'ALTER TABLE ' . $contentType->content_type
				. ( $update ? ' CHANGE ' : ' ADD ' ) . 'COLUMN '
				. ( $update ? $contentField->name . ' ' . $contentField->name : $contentField->name ) . ' '
				. $this->_getColumnType( $contentField->type )
				. ( $contentField->mandatory ? ' NOT NULL' : ' NULL');

		// ALTER TABLE `table_name` ADD COLUMN `column_name` `data_type`;
		// ALTER TABLE `members` CHANGE COLUMN `full_names` `fullname` char(250) NOT NULL;

		try {

			DB::beginTransaction();
			DB::statement( $query );


			if ( $update ) {
				if ( $contentField->mandatory ) {
					DB::table( $contentType->content_type )
						->whereNull( $contentField->name )
						->update( [ $contentField->name => '' ] );
				} else {
					$compareValue = ( $contentField->type == 'linked_content' ? 0 : '' );

					DB::table( $contentType->content_type )
						->where( $contentField->name, $compareValue )
						->update( [ $contentField->name => null ] );
				}
			}

			DB::commit();

			$this->_saveJsonModel( $contentType );

		} catch ( \Exception $ex) {
			DB::rollBack();
			echo $ex->getMessage();
			print_r($ex->getTrace());
			die;
		}

	}


	public function created(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$this->_setColumnField( $contentField, false );
		}
	}


	public function updating(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$contentType = ContentType::find($contentField->content_type_id);

			$table = null;
			$oldContentField = $contentField->old_content_field;

			if ( $oldContentField !== $contentField->name ) {
				// Alter relative table
				Schema::table( $contentType->content_type, function (Blueprint $table)  use ( $oldContentField, $contentField) {
					if ( $oldContentField != '' && $contentField->name != $oldContentField ) {
						$table->renameColumn( $oldContentField, $contentField->name );
					}
				});
			}
		}
	}


	public function updated(ContentField $contentField)
	{
		if ( $contentField::$FIRE_EVENTS ) {
			$this->_setColumnField( $contentField, true );
		}
	}


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

			$obj = [];
			$rel = [];

			foreach ( $fields as $f ) {

				$tmp = [
					'type' => $f->type
				];

				if ( in_array($f->type, [ 'image_upload', 'file_upload', 'gallery', 'linked_content', 'multiple_linked_content' ] )) {
					$tmp['need_parsing'] = true;
				}

				if ( in_array($f->type, [ 'image_upload', 'gallery' ] )) {
					$tmp['sizes'] = $f->resizes;
				}

				if ( in_array($f->type, [ 'linked_content', 'multiple_linked_content' ] )) {
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