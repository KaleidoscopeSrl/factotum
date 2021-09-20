<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Models\ContentField;


class FactotumMigrateContentTypeAndFields extends Command
{

	protected $signature = 'factotum:migrate-content-type-fields {contentType}';


	protected $description = 'Migrate content type and fields from Factotum 1 to Factotum 4';


	public function handle()
	{
		$contentTypeName = $this->argument('contentType');
		$contentType     = DB::connection('old_fm')
								->table( 'content_types' )
								->where('content_type', '=', $contentTypeName )
								->first();

		$contentTypeAlreadyExist = ContentType::where( 'content_type', $contentType->content_type )->count();

		$this->info('Starting migration of Content Type and Fields');

		if ( $contentTypeAlreadyExist == 0 ) {

			$cType = new ContentType;
			$cType->content_type = $contentType->content_type;
			$cType->editable     = $contentType->editable;
			$cType->icon         = 'content';
			$cType->save();

			$this->info('Content Type ' . $cType->content_type . ' created');

			$contentFields = DB::connection('old_fm')
								->table( 'content_fields' )
								->where( 'content_type_id', '=', $contentType->id )
								->get();

			if ( $contentFields->count() > 0 ) {

				foreach ( $contentFields as $cf ) {

					$data = (array) $cf;

					$newContentField = new ContentField;

					unset($data['id']);
					$data['content_type_id'] = $cType->id;

					$data = $this->_convertResizes( $data );
					$data = $this->_convertAllowedTypes( $data );
					$data = $this->_convertOptions( $data );
					$data = $this->_convertLinkedContent( $data );



					$newContentField->fill( $data );
					$newContentField->save();

					$this->info('Content Field ' . $newContentField->label . ' created');

				}

			}

			$this->info('Content Type and Fields migrated');

		} else {
			$this->error('Content Type already exist');
		}

	}




	// OLD FORMAT
	// 1024:1024;900:594;667:667;360:277;313:241;274:210

	// NEW FORMAT
	// [{"w":"640","h":"1136"},{"w":"1024","h":"768"},{"w":"768","h":"1024"},{"w":"375","h":"627"}]

	private function _convertResizes( $data )
	{
		if ( $data['resizes'] != '' ) {
			$newSizes = [];
			$sizes    = explode(';', $data['resizes'] );

			foreach ( $sizes as $s ) {
				list( $w, $h ) = explode( ':', $s );
				$newSizes[] = [ 'w' => $w, 'h' => $h ];
			}

			$data['resizes'] = json_encode( $newSizes );
		}

		return $data;
	}




	// OLD FORMAT
	// .jpg,.png

	// NEW FORMAT
	// ["png", "jpg"]
	private function _convertAllowedTypes( $data )
	{
		if ( $data['allowed_types'] != '' ) {
			$newAllowedTypes = [];
			$allowedTypes    = explode( ',', $data['allowed_types'] );

			foreach ( $allowedTypes as $at ) {
				$newAllowedTypes[] = $at;
			}

			$data['allowed_types'] = json_encode( $newAllowedTypes );
		}

		return $data;
	}




	// OLD FORMAT
	// basic:Basic Page Template;content_list:Content List Page Template;

	// NEW FORMAT
	// [{"value":"show_content","label":"Show Page Content"},{"value":"single_content","label":"Show Related Content"},]
	private function _convertOptions( $data )
	{
		if ( $data['options'] != '' ) {
			$newOptions = [];
			$options    = explode( ';', $data['options'] ) ;

			foreach ( $options as $opt ) {
				list( $value, $label ) = explode( ':', $opt );

				$newOptions[] = [
					'value' => $value,
					'label' => $label
				];
			}

			$data['options'] = json_encode( $newOptions );
		}

		return $data;
	}




	private function _convertLinkedContent( $data )
	{
		if ( $data['linked_content_type_id'] != '' ) {
			$contentType = DB::connection('old_fm')
								->table( 'content_types' )
								->where('id', '=', $data['linked_content_type_id'] )
								->first();

			$contentTypeAlreadyExist = ContentType::where( 'content_type', $contentType->content_type )->get();
			if ( $contentTypeAlreadyExist->count() > 0 ) {
				foreach ( $contentTypeAlreadyExist as $ct ) {
					$data['linked_content_type_id'] = $ct->id;
				}
			} else {
				$this->error('Content Type ' . $contentType->content_type . ' not exist on new installation of Factotum.');
				die;
			}
		}

		return $data;
	}

}