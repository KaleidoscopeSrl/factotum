<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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

	// CUSTOM FILL
	public function fill(array $attributes)
	{
		if ( isset( $attributes[ 'name' ] ) ) {
			$attributes[ 'url' ] = Str::slug( $attributes[ 'name' ] );

			$shopBaseUrl = config('factotum.shop_base_url');

			if ( $shopBaseUrl && substr($shopBaseUrl, 0, 1) != '/' ) {
				$shopBaseUrl = '/' . $shopBaseUrl;
			}

			$attributes[ 'abs_url' ] = $shopBaseUrl . '/brands/' . $this->url;
		}

		return parent::fill($attributes);
	}
}
