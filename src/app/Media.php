<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Image;

use Kaleidoscope\Factotum\Library\Utility;

class Media extends Model
{
	protected $fillable = [
		'width', 'height', 'size', 'filename',
		'caption', 'alt_text', 'description', 'user_id',
		'mime_type'
	];

	//Add extra attribute
	protected $attributes = ['thumb'];

	//Make it available in the json response
	protected $appends = ['thumb'];

	public static function filenameAvailable($filename, $origFilename = null, $counter = '')
	{

		$filename = str_replace('.jpeg', '.jpg', $filename);

		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$filename = str_slug( substr( $filename, 0, strlen('.' . $extension) * -1 ) ) . '.' . $extension;

		$mediaExist = Media::where('filename', $filename)->get();

		if ( !$origFilename ) {
			$origFilename = $filename;
		}

		if ( $mediaExist->count() > 0 ) {
			if (!$counter) {
				$counter = 1;
			} else {
				$counter++;
			}
			$filename = substr( $origFilename, 0, strlen('.' . $extension) * -1 ) . '-' . $counter . '.' . $extension;
			return self::filenameAvailable($filename, $origFilename, $counter);
		}
		return $filename;
	}

	public static function checkImageSizesNotExist( $field, $media )
	{
		$origImage    = Image::make( $media->url );
		$origFilename = $origImage->dirname . '/' . $origImage->filename;
		$ext          = $origImage->extension;

		$sizesNotExist = false;

		if ( $field->resizes ) {
			$resizes = Utility::convertOptionsTextToAssocArray( $field->resizes );
			foreach ($resizes as $width => $height) {
				$newFilename = $origFilename . '-' . $width .'x' . $height . '.' . $ext;
				if ( !File::exists($newFilename) ) {
					$sizesNotExist = true;
					break;
				}
			}
		}
		return $sizesNotExist;
	}

	public static function retrieve( $mediaId, $fieldModel )
	{
		if ( !is_array($mediaId) ) {
			$media = self::find($mediaId);

			if ( $media ) {
				$media = $media->toArray();

				if ( isset($fieldModel->sizes) && $fieldModel->sizes != '' ) {
					$mediaUrl = substr( $media['url'], 0, -4);
					$ext = substr( $media['filename'], strlen($media['filename'])-3, 3 );

					if ( count($fieldModel->sizes) > 0 ) {
						$tmp = array();
						foreach ( $fieldModel->sizes as $size ) {
							$tmp[] = $mediaUrl . $size . '.' . $ext ;
						}
						$media['sizes'] = $tmp;
					}
				}
				return $media;
			}
		} else if ( is_array($mediaId) ) {
			return $mediaId;
		}
		return null;
	}

	// Dato un Campo e un MediaId, eseguo la funzione saveImage per quell'immagine
	public static function saveImageById( $field, $mediaId )
	{
		$media = Media::find( $mediaId );
		if ( $media ) {
			return self::saveImage( $field, $media->url );
		} else {
			return null;
		}
	}

	// Dato un Campo e un MediaUrl, eseguo tutte le operazioni creazioni crop/resize/fit per quell'immagine
	public static function saveImage( $field, $filename )
	{
		if ( $field->image_bw ) {
			$origImage = Image::make( $filename )->greyscale();
		} else {
			$origImage = Image::make( $filename );
		}

		$origFilename = $origImage->dirname . '/' . $origImage->filename;
		$ext          = $origImage->extension;

		$operation = $field->image_operation;

		if ( $field->resizes ) {

			foreach ( json_decode($field->resizes,true) as $resize ) {
				$width  = $resize['w'];
				$height = $resize['h'];

				$newFilename = $origFilename . '-' . $width .'x' . $height . '.' . $ext;
				$image = Image::make( storage_path( 'app/' . $filename ) );

				if ($operation == 'resize') {
					$image->resize( $width, null, function ($constraint) {
						$constraint->aspectRatio();
					});
				} else if ($operation == 'crop') {
					$image->crop( $width, $height );
				} else if ($operation == 'fit') {
					$image->fit( $width, $height, function ($constraint) {
						$constraint->upsize();
					});
				}
				$image->save( $newFilename, 100 );
				$image->destroy();
			}
		}

		$thumbSize = config('factotum.thumb_size');
		$thumbFilename = $origFilename . '-thumb.' . $ext;
		$origImage->fit( $thumbSize['width'], $thumbSize['height'], function ($constraint) {
			$constraint->upsize();
		});

		$origImage->save( $thumbFilename, 90 );
		$origImage->destroy();

		return $origImage;
	}

	public static function generateThumb( $filename ) {

		if ( file_exists( storage_path( 'app/' . $filename ) ) ) {

			$image = Image::make( $filename );

			// Creo la thumb se è un immagine
			if ( $image && strpos( $image->mime, 'image/') !== false &&
				strpos( $image->mime, 'photoshop') === false ) {

				$origFilename = $image->dirname . '/' . $image->filename;
				$ext          = $image->extension;
				$thumbFilename = $origFilename . '-thumb.' .  $ext;

				$thumbSize = config('factotum.thumb_size');
				$image->fit( $thumbSize['width'], $thumbSize['height'], function ($constraint) {
					$constraint->upsize();
				});

				$image->save( $thumbFilename, 90 );
				$image->destroy();
			}

		}

	}

	public function getThumbAttribute()
	{
		$dirname = 'media/' . $this->id;
		$origFilename  = $dirname . '/' . pathinfo( $this->filename, PATHINFO_FILENAME );
		$ext           = pathinfo( $this->filename, PATHINFO_EXTENSION );
		$thumbFilename = $origFilename . '-thumb.' .  $ext;
		return url($thumbFilename);
	}

//	public function getUrlAttribute($value)
//	{
//		return ( $value ? url( $value ) : null );
//	}

}
