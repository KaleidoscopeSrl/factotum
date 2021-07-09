<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Library\Utility;


class Product extends Model
{

	use SoftDeletes;


	protected $fillable = [
		'code',
		'name',
		'active',
		'featured',
		'description',
		'image',
		'thumb',
		'barcode',
		'basic_price',
		'discount_price',
		'validity',
		'brand_id',
		'tax_id',

		'quantity',
		'has_variants',

		'url',
		'abs_url',
		'lang',
		'gallery',
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


	protected $appends = [
		'product_attributes'
	];


	public function brand() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Brand', 'id', 'brand_id');
	}


	public function product_categories() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Models\ProductCategory', 'product_product_category');
	}

	public function product_attribute_values() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Models\ProductAttributeValue', 'product_product_attribute_value');
	}

	public function product_variants() {
		return $this->hasMany('Kaleidoscope\Factotum\Models\ProductVariant');
	}

	public function tax() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Tax', 'id', 'tax_id');
	}

	public function orders() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Models\Order', 'order_product');
	}

	public function discount_codes() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Models\DiscountCode', 'product_discount_code');
	}


	// CUSTOM FILL
	public function fill(array $attributes)
	{
		if ( isset($attributes['name']) ) {
			$attributes['url'] = Str::slug( $attributes['name'] );
		}

		if ( isset($attributes['active']) ) {
			if ( $attributes['active'] == '' ) {
				$attributes['active'] = 0;
			}
		}

		if ( isset($attributes['image']) ) {
			$image = $attributes['image'];

			// Main image
			if ( isset($image) && is_array($image) && count($image) > 0 ) {
				if ( isset($image[0]['id']) ) {
					$attributes['image'] = $image[0]['id'];
				} else {
					$attributes['image'] = $image[0];
				}
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


	// CUSTOM SAVE
	public function save( array $options = [] )
	{
		$productSaved = parent::save($options);

		$this->_saveAdditional( $this );

		return $productSaved;
	}




	protected function _saveAdditional( Product $product )
	{
		$data = request()->all();
		
		$this->generateAbsUrl();
		
		if ( count($data) > 0 ) {

			// Save Additional
			$this->_saveProductCategories( $product, $data );

			$this->_saveProductAttributes( $product, $data );

			$this->generateMainImage( $data );

			$this->generateGalleryImages( $data );

		}

		return $product;
	}


	protected function _saveProductCategories( $product, $data )
	{
		if ( isset($data['product_category_ids']) ) {
			ProductProductCategory::where( 'product_id', $product->id )->delete();

			$productCategoryIds = array_unique($data['product_category_ids']);
			foreach ( $productCategoryIds as $product_category_id ) {
				$product->product_categories()->attach( $product_category_id );
			}
		}
	}


	protected function _saveProductAttributes( $product, $data )
	{
		if ( isset($data['attributes']) ) {
			ProductProductAttributeValue::where('product_id', $product->id)->delete();

			// Ora salva i collegamenti tra prodotto e product_attribute_value
			if ( count($data['attributes']) > 0 ) {
				foreach( $data['attributes'] as $row ) {
					$productAttributeId = $row['product_attribute_id'];
					$values             = $row['values'];

					$tmpValueIds = [];

					foreach ( $values as $value ) {
						if ( !isset($value['id']) ) {
							$productAttributeValue = new ProductAttributeValue;
							$productAttributeValue->fill([
								'product_attribute_id' => $productAttributeId,
								'name'                 => $value['name'],
								'label'                => $value['label']
							]);
							$productAttributeValue->save();
							$valueId = $productAttributeValue->id;
						} else {
							$valueId = $value['id'];
						}

						$tmpValueIds[] = $valueId;
					}

					$tmpValueIds = array_unique($tmpValueIds);
					foreach ( $tmpValueIds as $tmpValueId ) {
						$product->product_attribute_values()->attach( $tmpValueId );
					}
				}
			}
		}
	}


	public function generateAbsUrl()
	{
		$shopBaseUrl = config('factotum.shop_base_url');

		if ( $shopBaseUrl && substr($shopBaseUrl, 0, 1) != '/' ) {
			$shopBaseUrl = '/' . $shopBaseUrl;
		}

		if ( $this->product_categories()->count() > 0 ) {
			$firstCategory = $this->product_categories()->first();
			$categories    = array_reverse( $firstCategory->getFlatParentsArray() );

			if ( count($categories) > 0 ) {
				$catUrl = '';
				foreach ( $categories as $cat ) {
					$catUrl .= '/' . $cat->name;
				}

				$absUrl = ( $shopBaseUrl ? $shopBaseUrl : '' ) . $catUrl . '/' . $this->url;
			} else {
				$absUrl = ( $shopBaseUrl ? $shopBaseUrl : '' ) . '/' . $this->url;
			}
		} else {
			$absUrl = $shopBaseUrl . '/' . $this->url;
		}

		$affected = DB::table('products')
						->where( 'id', $this->id )
						->update([ 'abs_url' => $absUrl ]);
	}


	public function generateMainImage( $data )
	{
		$productResizes         = config('factotum.product_resizes');
		$productResizeOperation = config('factotum.product_resize_operation');

		if ( isset($data['image']) && isset($productResizes) ) {
			$field                  = new ContentField;
			$field->image_bw        = false;
			$field->image_operation = ( $productResizeOperation ? $productResizeOperation : 'fit' );
			$field->resizes         = json_encode( $productResizes );

			if ( is_string($data['image']) || is_integer($data['image']) ) {
				$imageId = $data['image'];
			} elseif ( is_array($data['image']) ) {
				$imageId = $data['image'][0]['id'];
			}

			Media::saveImageById( $field, $imageId );
		}
	}


	public function generateGalleryImages( $data )
	{
		$productGalleryResizes         = config('factotum.product_gallery_resizes');
		$productGalleryResizeOperation = config('factotum.product_gallery_resize_operation');

		if ( isset($data['gallery']) && isset($productGalleryResizes) ) {
			$field                  = new ContentField;
			$field->image_bw        = false;
			$field->image_operation = ( $productGalleryResizeOperation ? $productGalleryResizeOperation : 'fit' );
			$field->resizes         = json_encode( $productGalleryResizes );

			if ( is_string($data['gallery']) ) {
				$gallery = explode( ',', $data[ 'gallery' ] );
			} else if ( is_array($data['gallery']) ) {
				$tmp = [];
				foreach ( $data['gallery'] as $media ) {
					$tmp[] = $media['id'];
				}
				$gallery = $tmp;
			}

			foreach ( $gallery as $g ) {
				Media::saveImageById( $field, $g );
			}

		}
	}


	protected function _getMediaFromValue( $value )
	{
		if ( $value ) {

			if ( substr($value, 0, 4) == 'http' ) {
				return $value;
			}

			if ( $value ) {
				$media = Media::find($value);
				$media = $media->toArray();

				$productResizes = config('factotum.product_resizes');

				if ( isset($productResizes) && $productResizes ) {
					$mediaUrl = substr( $media['url'], 0, -4);
					$ext      = substr( $media['filename'], strlen($media['filename'])-3, 3 );

					if ( count($productResizes) > 0 ) {
						$tmp = [];
						foreach ( $productResizes as $size ) {
							$width  = $size['w'];
							$height = $size['h'];

							$sizePath = storage_path( 'app/public/media/' . $media['id'] . '/' . substr( $media['filename'], 0, -4) . '-' . $width .'x' . $height . '.' . $ext);
							if ( !file_exists($sizePath) ) {
								Media::generateSize( $media, $size );
							}

							$tmp[] = $mediaUrl . '-' . $size['w'] . 'x' . $size['h'] . '.' . $ext ;
						}
						$media['sizes'] = $tmp;
					}
				}

				return $media;
			}

			return $value;
		}

		return null;
	}


	private function _getMultipleMediaFromValue( $value )
	{
		if ( $value ) {
			$gallery = Media::whereIn( 'id', explode(',', $value) )->get();

			$productGalleryResizes = config('factotum.product_gallery_resizes');

			if ( isset($productGalleryResizes) && $productGalleryResizes ) {
				foreach ( $gallery as $i => $media ) {
					$mediaUrl = substr( $media['url'], 0, -4);
					$ext      = substr( $media['filename'], strlen($media['filename'])-3, 3 );

					if ( count($productGalleryResizes) > 0 ) {
						$tmp = [];
						foreach ( $productGalleryResizes as $size ) {
							$tmp[] = $mediaUrl . '-' . $size['w'] . 'x' . $size['h'] . '.' . $ext ;
						}
						$media['sizes'] = $tmp;
					}

					$gallery[$i] = $media;
				}
			}

			return $gallery;
		}

		return null;
	}



	// MUTATORS

	public function getImageAttribute($value)
	{
		return $this->_getMediaFromValue( $value );
	}

	public function getFbImageAttribute($value)
	{
		return $this->_getMediaFromValue( $value );
	}

	public function getGalleryAttribute($value)
	{
		return $this->_getMultipleMediaFromValue( $value );
	}

	public function getProductAttributesAttribute($value)
	{
		$tmp    = [];
		$setted = [];
		$pavs   = $this->product_attribute_values;

		if ( count($pavs) > 0 ) {

			$filter = [];
			foreach ( $pavs as $pav ) {
				$filter[] = $pav->id;
			}

			foreach ( $pavs as $pav ) {
				if ( !isset($setted[ $pav->product_attribute_id ]) ) {
					$setted[ $pav->product_attribute_id ] = true;
					$pa = $pav->product_attribute;

					$pa->load(['values' => function ($q) use($filter) {
						$q->whereIn('id', $filter);
					}]);

					$tmp[] = $pav->product_attribute;
				}
			}
		}

		return $tmp;
	}

}
