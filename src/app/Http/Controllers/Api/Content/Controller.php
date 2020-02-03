<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Requests\StoreContent;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\CategoryContent;
use Kaleidoscope\Factotum\Media;


class Controller extends ApiBaseController
{
	protected $statuses;
	protected $_contentType;
	protected $_contentFields;
	protected $_contents;
	protected $_categories;
	protected $_categoriesContent;
	protected $_additionalValues;

	protected function _saveContent( StoreContent $request, $content )
	{
		$data = $request->all();

		// Categories
		if ( isset($data['categories']) ) {
			CategoryContent::where( 'content_id', $content->id )->delete();

			foreach ( $data['categories'] as $categoryID ) {
				$categoryContent = new CategoryContent;
				$categoryContent->content_id  = $content->id;
				$categoryContent->category_id = $categoryID;
				$categoryContent->save();
			}
		}

		// TODO: Eventuali operazioni sulle immagini selezionate in base alle regole del campo
		// es. resize oppure crop etc

		// Save Additional Fields
		$contentType   = ContentType::find($data['content_type_id']);
		$contentFields = ContentField::where( 'content_type_id', '=', $content->content_type_id )->get();

		if ( $contentType && $contentFields->count() > 0 ) {

			$additionalValuesExists = DB::table( $contentType->content_type )
										->where( 'content_type_id', $contentType->id )
										->where( 'content_id', $content->id )
										->first();

			$additionalValues = array(
				'content_type_id' => $contentType->id,
				'content_id'      => $content->id
			);

			$this->contentDir = 'media/' . $content->id;

			foreach ( $contentFields as $field ) {

				// Multioptions fields
				if ( isset( $data[ $field->name ] ) &&
					 ( $field->type == 'multicheckbox' ||
						 $field->type == 'multiselect' ||
						 $field->type == 'multiple_linked_categories' ||
						 $field->type == 'multiple_linked_content' ) ) {
					if ( is_array($data[ $field->name ]) ) {
						$data[ $field->name ] = Utility::convertOptionsArrayToText( $data[ $field->name ] );
					}
				}

				// Date fields
				if ( isset( $data[ $field->name ] ) && $field->type == 'date' && $data[$field->name] != '' ) {
					$data[$field->name] = Utility::convertHumanDateToIso($data[$field->name]);
				}

				// Date-time fields
				if ( isset( $data[ $field->name ] ) && $field->type == 'datetime' && $data[$field->name] != '' ) {
					$data[$field->name] = Utility::convertHumanDateTimeToIso($data[$field->name]);
				}

				// Image & Gallery Operation
				if ( $field->type == 'gallery' || $field->type == 'image_upload' ) {

					// eseguo operazione di resize
					if ( isset( $data[ $field->name ] ) ) {
						Media::saveImageById( $field, $data[ $field->name ] );
					}

				}

				$additionalValues[ $field->name ] = (isset($data[ $field->name ]) ? $data[ $field->name ] : null);
			}

			if ( $additionalValuesExists ) {
				DB::table( $contentType->content_type )
					->where( 'id', $additionalValuesExists->id )
					->update( $additionalValues );
			} else {
				DB::table( $contentType->content_type )
					->insert( $additionalValues );
			}

		}

		return $content;
	}


}
