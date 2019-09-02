<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Media;


class UploadController extends Controller
{
	public function showUpload( Request $request, $contentFieldName )
	{
		$field = $this->_getField($contentFieldName);

		if ( $field->type == 'image_upload' || $field->type == 'gallery' ) {
			$media = $this->_getImagesPaginated( 0 );
		} else {
			$media = $this->_getMediaPaginated( 0, $field->allowed_types );
		}

		foreach ($media as $i => $m ) {
			$media[ $i ] = $this->_parseMedia( $m , $field->name );
		}

		$btnLabel = ( $field->type == 'image_upload' || $field->type == 'gallery' ? Lang::get('factotum::media.insert_image') : Lang::get('factotum::media.insert_media') );

		$selected = $request->input('selected', null);

		if ( $selected ) {
			$selected = Utility::convertOptionsTextToArray($selected);
		}

		return view('factotum::admin.media.upload')
					->with('media', $media)
					->with('mediaOffset', count($media))
					->with('field', $field)
					->with('selected', $selected)
					->with('btnLabel', $btnLabel)
					->with('maxFiles', ($field->type == 'gallery' ? 999 : 999 ))
					->with('required', $field->mandatory);
	}

	public function upload( Request $request )
	{
		$data = $request->all();

		$fieldName = $request->input('field_name');

		$field = $this->_getField($fieldName);

		$validation = $this->validator( $request, $data, $field );

		if ( $validation['status'] == 'ok' ) {
			$file = $request->file('media');

			$filename = $file->getClientOriginalName();
			$filename = Media::filenameAvailable($filename, $filename);

			$media = new Media;
			$media->user_id   = Auth::user()->id;
			$media->filename  = $filename;
			$media->mime_type = $file->getMimeType();
			$media->save();

			$mediaDir = 'media/' . $media->id;
			Storage::makeDirectory( $mediaDir );

			$path = $file->storeAs( $mediaDir, $filename );

			$media->url = $path;
			$media->save();

			if ( $field ) {
				if ( $file && ( $field->type == 'image_upload' || $field->type == 'gallery' ) ) {
					Media::saveImage( $field, storage_path( 'app/' . $media->url ) );
				}
			}

			if ( $media->id ) {
				return response()->json( [ 'status' => 'ok', 'media' => [ $this->_parseMedia( $media->toArray() ) ] ]);
			} else {
				return response()->json( [ 'status' => 'ko' ], 400);
			}
		} else {
			return response()->json( [ 'status' => 'ko', 'error' => $validation['error'] ], 400);
		}
	}


	protected function validator( Request $request, array $data, $field = null )
	{
		if ( $field ) {

			if ( $field->mandatory ) {
				$tmp[] = 'required';
			}

			if ( $field->max_file_size ) {
				$tmp[] = 'max_mb:' . $field->max_file_size;
			}

			if ($field->allowed_types != '*') {
				$field->allowed_types = str_replace('jpg', 'jpeg', $field->allowed_types);
				$field->allowed_types = str_replace('.', '', $field->allowed_types);
				$tmp[] = 'mimes:' . $field->allowed_types;
			}

			if ( $field->type == 'image_upload' || $field->type == 'gallery' ) {
				$tmp[] = 'dimensions:min_width=' . $field->min_width_size . ',min_height=' . $field->min_height_size;
			}

			$rules = array(
				'media' => join( '|', $tmp )
			);

		} else {
			$rules = array(
				'media' => 'image|max_mb:3'
			);
		}

		$validation = Validator::make($data, $rules);


		if ( $validation->fails() ) {
			return array( 'status' => 'ko', 'error' => $validation->errors()->first() );
		} else {
			return array( 'status' => 'ok' );
		}
	}

}
