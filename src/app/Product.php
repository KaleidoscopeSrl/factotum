<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
	use SoftDeletes;


	protected $fillable = [
		'code',
		'name',
		'active',
		'featured',
		'status',
		'description',
		'image',
		'thumb',
		'barcode',
		'basic_price',
		'discount_price',
		'validity',
		'brand_id',
		'category_id',
		'tax_id',

		'url',
		'abs_url',
		'lang',
		'gallery',
		'attributes',
		'order_no',

		'seo_title',
		'seo_description',
		'seo_canonical_url',
		'seo_robots_indexing',
		'seo_robots_following',
		'seo_focus_key',

		'fb_title',
		'fb_description',
		'fb_image'
	];



	protected $hidden = [
		'deleted_at'
	];


	public function brand() {
		return $this->hasOne('Kaleidoscope\Factotum\Brand', 'id', 'brand_id');
	}


	public function product_category() {
		return $this->hasOne('Kaleidoscope\Factotum\ProductCategory', 'id', 'product_category_id');
	}

	public function tax() {
		return $this->hasOne('Kaleidoscope\Factotum\Tax', 'id', 'tax_id');
	}

	public function orders() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Order', 'order_product');
	}

	public function discount_codes() {
		return $this->belongsToMany('Kaleidoscope\Factotum\DiscountCode', 'product_discount_code');
	}


	public function getImageAttribute($value)
	{
		return $this->_getMediaFromValue( $value );
	}


	public function getFbImageAttribute($value)
	{
		return $this->_getMediaFromValue( $value );
	}

	public function getAttributesAttribute($value)
	{
		return ( $value ? json_decode( $value ) : null );
	}

	public function getGalleryAttribute($value)
	{
		return $this->_getMultipleMediaFromValue( $value );
	}


	// CUSTOM FILL
	public function fill(array $attributes)
	{
		if ( isset($attributes['active']) ) {
			if ( $attributes['active'] == '' ) {
				$attributes['active'] = 0;
			}
		}

		if ( isset($attributes['image']) ) {
			$image = $attributes['image'];

			// Main image
			if ( isset($image) && is_array($image) && count($image) > 0 ) {
				$attributes['image'] = $image[0]['id'];
			} else if ( isset($image) && is_string($image) ) {
				$attributes['image'] = ( substr($image, 0, 4) == 'http' ? $image : null );
			} else {
				$attributes['image'] = null;
			}
		}

		if ( isset($attributes['fb_image']) ) {
			$fbImage = $attributes['fb_image'];

			// Fb Image
			if ( isset($fbImage) && is_array($fbImage) && count($fbImage) > 0 ) {
				$attributes['fb_image'] = $fbImage[0]['id'];
			} else if ( isset($fbImage) && is_string($fbImage) ) {
				$attributes['fb_image'] = ( substr($fbImage, 0, 4) == 'http' ? $fbImage : null );
			} else {
				$attributes['fb_image'] = null;
			}
		}

		if ( isset($attributes['gallery']) ) {
			$gallery = $attributes['gallery'];

			// Gallery
			if ( isset($gallery) && count($gallery) > 0 ) {
				$tmp = [];
				foreach ( $gallery as $img ) {
					$tmp[] = $img['id'];
				}
				$attributes['gallery'] = join( ',', $tmp );
			} else {
				$attributes['gallery'] = null;
			}
		}

		return parent::fill($attributes);
	}

	private function _getMediaFromValue( $value )
	{
		if ( $value ) {

			if ( substr($value, 0, 4) == 'http' ) {
				return $value;
			}

			$media = Media::find($value);
			return ( $media ? [ Media::find($value) ] : null );
		}

		return null;
	}

	private function _getMultipleMediaFromValue( $value )
	{
		if ( $value ) {
			$media = Media::whereIn( 'id', explode(',', $value) )->get();
			return $media;
		}

		return null;
	}

}
