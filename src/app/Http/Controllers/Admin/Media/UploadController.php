<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Media;

class UploadController extends Controller
{

	public function upload( Request $request )
	{
		$data = $request->all();

		$fieldID = $request->input('field_id');

		$field = null;
		if ( $fieldID != 'undefined' ) {
			if ( $fieldID == 'fb_image' ) {
				$field = new \stdClass();
				$field->type            = 'image_upload';
				$field->mandatory       = false;
				$field->image_operation = 'fit';
				$field->max_file_size   = 2000;
				$field->allowed_types   = '.jpg,.png';
				$field->min_width_size  = 200;
				$field->min_height_size = 200;
				$field->image_bw        = false;
				$field->resizes         = null;
			} else {
				$field = ContentField::find($fieldID);
			}
		}

		$validation = $this->validator( $request, $data, $field );

		if ( $validation['status'] == 'ok' ) {
			$file = $request->file('media');

			$filename = $file->getClientOriginalName();
			$filename = Media::filenameAvailable($filename, $filename);

			$media = new Media;
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
					Media::saveImage( $field, $media->url );
				}
			}

			if ( $media->id ) {
				return response()->json( [ 'status' => 'ok', 'id' => $media->id, 'link' => asset($media->url) ]);
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
				$tmp[] = 'max:' . $field->max_file_size;
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
				'media' => 'image|max:3000'
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
