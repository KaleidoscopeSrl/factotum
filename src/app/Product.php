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
		'status',
		'description',
		'image',
		'barcode',
		'basic_price',
		'discount_price',
		'validity',
		'brand_id',
		'category_id',

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


	public function category() {
		return $this->hasOne('Kaleidoscope\Factotum\ProductCategory', 'id', 'category_id');
	}

	public function orders() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Order', 'order_product');
	}

	public function getImageAttribute($value)
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

}
