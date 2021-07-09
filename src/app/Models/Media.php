<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

use Kaleidoscope\Factotum\Library\Utility;

class Media extends Model
{

	protected $fillable = [
		'user_id',
		'width',
		'height',
		'size',
		'filename',
		'thumb',
		'url',
		'filename_webp',
		'thumb_webp',
		'url_webp',
		'caption',
		'alt_text',
		'description',
		'mime_type'
	];

	protected $appends = ['icon'];


	public static function filenameAvailable($filename, $origFilename = null, $counter = '')
	{
		$filename = str_replace('.jpeg', '.jpg', $filename);

		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$filename = Str::slug( substr( $filename, 0, strlen('.' . $extension) * -1 ) ) . '.' . $extension;

		$mediaExist = Media::where('filename', $filename)->get();

		if ( !$origFilename ) {
			$origFilename = $filename;
		}

		if ( $mediaExist->count() > 0 ) {

			if ( !$counter ) {
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
					$ext      = substr( $media['filename'], strlen($media['filename'])-3, 3 );

					if ( count($fieldModel->sizes) > 0 ) {
						$tmp = [];
						foreach ( $fieldModel->sizes as $size ) {
							$tmp[] = $mediaUrl . '-' . $size->w . 'x' . $size->h . '.' . $ext ;
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
		if ( $media && in_array($media->mime_type, [ 'image/jpeg', 'image/png', 'image/gif' ]) ) {
			return self::saveImage( $field, $media );
		} elseif ( $media ) {
			return $media;
		}
		return null;
	}


	// Dato un Campo e un MediaUrl, eseguo tutte le operazioni creazioni crop/resize/fit per quell'immagine
	public static function saveImage( $field, $media )
	{
		$startingFile = storage_path( 'app/public/media/' . $media->id . '/' . $media->filename );
		$origImage    = ( $field->image_bw ? Image::make( $startingFile )->greyscale() : Image::make( $startingFile ) );
		$origFilename = $origImage->dirname . '/' . $origImage->filename;
		$ext          = $origImage->extension;
		$operation    = $field->image_operation;

		if ( $field->resizes ) {

			foreach ( $field->resizes as $resize ) {

				$width  = $resize['w'];
				$height = $resize['h'];

				$newFilename = $origFilename . '-' . $width .'x' . $height . '.' . $ext;
				$image       = Image::make( storage_path( 'app/public/media/' . $media->id . '/' . $media->filename ) );

				switch ( $operation ) {

					case 'resize':
						$image->resize( $width, null, function ($constraint) { $constraint->aspectRatio(); });
						break;

					case 'crop':
						$image->crop( $width, $height );
						break;

					case 'fit':
						$image->fit( $width, $height, function ($constraint) { $constraint->upsize(); });
						break;

				}

				$image->save( $newFilename, 100 );
				$image->destroy();
			}

		}

		$thumbSize         = config('factotum.thumb_size');
		$thumbFilename     = $origFilename . '-thumb.' . $ext;
		$thumbFilenameWebP = $origFilename . '-thumb.webp';

		$origImage->fit( $thumbSize['width'], $thumbSize['height'], function ($constraint) { $constraint->upsize(); });
		$origImage->save( $thumbFilename, 90 );
		$origImage->encode('webp')->save( $thumbFilename, 90 );
		$origImage->destroy();

		return $origImage;
	}


	public static function generateSize( $media, $resize )
	{
		$width  = $resize['w'];
		$height = $resize['h'];

		$ext      = substr( $media['filename'], strlen($media['filename'])-3, 3 );

		$newFilename = storage_path( 'app/public/media/' . $media['id'] . '/' . substr( $media['filename'], 0, -4) . '-' . $width .'x' . $height . '.' . $ext);
		$image       = Image::make( storage_path( 'app/public/media/' . $media['id'] . '/' . $media['filename'] ) );

		$image->resize( $width, null, function ($constraint) { $constraint->aspectRatio(); });

		$image->save( $newFilename, 100 );
		$image->destroy();
	}


	public static function generateThumb( $media )
	{
		if ( File::exists( storage_path( 'app/public/media/' . $media->id . '/' . $media->filename ) ) ) {

			$image = Image::make( storage_path( 'app/public/media/' . $media->id . '/' . $media->filename ) );

			$origFilename      = $image->dirname . '/' . $image->filename;
			$ext               = $image->extension;

			$image->encode('webp')->save( $origFilename . '.webp', 90 );

			// Creo la thumb se è un immagine
			if ( $image && strpos( $image->mime, 'image/') !== false && strpos( $image->mime, 'photoshop') === false ) {

				$thumbSize = config('factotum.thumb_size');

				$thumbFilename     = $origFilename . '-thumb.' .  $ext;
				$thumbFilenameWebp = $origFilename . '-thumb.webp';

				$image->fit( $thumbSize['width'], $thumbSize['height'], function ($constraint) {
					$constraint->upsize();
				});

				$image->save( $thumbFilename, 90 );
				$image->encode('webp')->save( $thumbFilenameWebp, 90 );
				$image->destroy();

				$media->thumb      = 'media/' . $media->id . '/' . $image->filename . '.' . $ext;
				$media->thumb_webp = 'media/' . $media->id . '/' . $image->filename . '.webp';
				$media->save();
			}

		}

		return $media;
	}



	// MUTATORS

	public function getUrlAttribute($value)
	{
		return ( $value ? url( $value ) : null );
	}

	public function getThumbAttribute($value)
	{
		return ( $value ? url( $value ) : null );
	}

	public function getUrlWebpAttribute($value)
	{
		return ( $value ? url( $value ) : null );
	}

	public function getThumbWebpAttribute($value)
	{
		return ( $value ? url( $value ) : null );
	}

	public function getCreatedAtAttribute($value)
	{
		return strtotime( $value ) * 1000;
	}

	public function getUpdatedAtAttribute($value)
	{
		return strtotime( $value ) * 1000;
	}

	public function getIconAttribute($value) {
		$tmp = explode( '/', $this->mime_type );
		return $tmp[1];
	}

}
