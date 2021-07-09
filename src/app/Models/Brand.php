<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Brand extends Model
{

	use SoftDeletes;

	protected $fillable = [
		'code',
		'name',
		'url',
		'abs_url',
		'seo_title',
		'seo_description',
		'logo',
		'logo_thumb',
		'order_no'
	];


	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	protected $appends = [
		'total_products'
	];

	public function products() {
		return $this->hasMany('Kaleidoscope\Factotum\Models\Product');
	}


	public function getLogoAttribute($value)
	{
		if ( $value ) {

			if ( substr( $value, 0, 4 ) == 'http' ) {
				return $value;
			}

			return [ Media::find($value) ];
		}

		return null;
	}


	public function getTotalProductsAttribute()
	{
		return Product::where('brand_id', $this->id)->count();
	}

}
