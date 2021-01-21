<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ProductCategory extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'parent_id',
		'abs_url',
		'name',
		'label',
		'lang',
		'image',
		'description',
		'order_no',
		'show_in_home'
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at'
	];

	protected $appends = [
		'total_products'
	];


	public function products() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Product', 'product_product_category');
	}

	public function parent() {
		return $this->belongsTo( 'Kaleidoscope\Factotum\ProductCategory', 'parent_id');
	}

	public function childs() {
		return $this->hasMany('Kaleidoscope\Factotum\ProductCategory','parent_id','id') ;
	}


	public function childrenRecursive()
	{
		return $this->childs()->with('childrenRecursive');
	}


	public function parentRecursive()
	{
		return $this->parent()->with('parentRecursive');
	}


	public function getFlatChildsArray()
	{
		return ProductCategory::_parseFlatTreeChilds( [ $this ], 0 );
	}


	public static function treeChildsArray( $pagination = null, $filters = null, $orderBy = 'order_no', $sortBy = 'ASC' )
	{
		$categories = self::_getChildCategories( null, $pagination, $filters, $orderBy, $sortBy );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseChildsTree( $categories );
		}

		return $categories->toArray();
	}


	public static function treeChildsObjects( $pagination = null, $filters = null, $orderBy = 'order_no', $sortBy = 'ASC' )
	{
		$categories = self::_getChildCategories( null, $pagination, $filters, $orderBy, $sortBy );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseChildsTree( $categories );
		}

		return $categories;
	}


	private static function _getChildCategories( $category = null, $pagination = null, $filters = null, $orderBy = 'order_no', $sortBy = 'ASC' )
	{
		if ( $category ) {
			$query = ProductCategory::where( 'id', $category->id )->orderBy($orderBy, $sortBy);
		} else {
			$query = ProductCategory::whereNull( 'parent_id' )->orderBy($orderBy, $sortBy);
		}

		if ( request()->input('lang') ) {
			$query->where( 'lang', request()->input('lang') );
		}

		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(label) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(name) like "%' . $filters['term'] . '%"' );
			}

		}

		if ( $pagination ) {
			return $query->paginate($pagination);
		} else {
			return $query->get();
		}
	}


	private static function _parseChildsTree( $categories )
	{
		foreach ( $categories as $c ) {
			if ( $c->childs->count() > 0 ) {
				$c->childs = self::_parseChildsTree($c->childs);
			}
		}

		return $categories;
	}


	public static function flatTreeChildsArray( $pagination = null, $filters = null, $orderBy = 'order_no', $sortBy = 'ASC' )
	{
		$categories = self::_getChildCategories( null, $pagination, $filters, $orderBy, $sortBy );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseFlatTreeChilds( $categories );
		}

		return $categories;
	}


	public function singleCategoryFlatTreeChildsArray( $pagination = null, $filters = null, $orderBy = 'order_no', $sortBy = 'ASC' )
	{
		$categories = self::_getChildCategories( $this, $pagination, $filters, $orderBy, $sortBy );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseFlatTreeChilds( $categories );
		}

		return $categories;
	}


	private static function _parseFlatTreeChilds( $categories, $level = 0, $parent = null )
	{
		$result = [];

		foreach ( $categories as $c ) {

			$childs = null;
			if ( $c->childs->count() > 0 ) {
				$childs = $c->childs;
			}

			unset($c->childs);

			// TODO: fix label repeat stuff
			// $c->label = str_repeat('-', $level ) . $c->label;

			if ( $parent ) {
				$c->abs_url = $parent->abs_url . '/' . $c->name;
			} else {
				$c->abs_url = $c->name;
			}

			$result[] = $c;

			if ( $childs ) {
				$level = $level + 1;
				$result = array_merge( $result, self::_parseFlatTreeChilds($childs, $level, $c) );
			}
		}

		return $result;
	}

	

	private static function _rewriteChildsAbsUrl( $categories, $level = 0, $parent = null )
	{
		foreach ( $categories as $c ) {

			$childs = null;

			if ( $c->childs->count() > 0 ) {
				$childs = $c->childs;
			}

			unset($c->childs);

			$absUrl = '';

			$lang = $c->lang;

			if ( $parent ) {
				$absUrl .= $parent->abs_url . '/' . $c->name;
			} else {

				if ( $c->lang != config('factotum.main_site_language') ) {
					$absUrl .= '/' . $lang;
				}

				$absUrl .= '/' . $c->name;
			}


			DB::table('product_categories')
				->where('id', $c->id)
				->update([ 'abs_url' => $absUrl ]);

			$c->abs_url = $absUrl;

			if ( $childs ) {
				$level = $level + 1;
				self::_rewriteChildsAbsUrl($childs, $level, $c);
			}
		}

	}


	public function save( $options = [] )
	{
		ProductCategory::_rewriteChildsAbsUrl( [ $this ], 0, $this->parent );

		parent::save();
	}


	private static function _parseFlatTreeParents( $categories, $level = 0 )
	{
		$result = [];
		foreach ( $categories as $c ) {

			$parent = null;
			if ( $c->parent ) {
				$parent = $c->parent;
			}

			unset($c->parent);

			$result[] = $c;

			if ( $parent ) {
				$level = $level + 1;
				$result = array_merge( $result, self::_parseFlatTreeParents( [ $parent ], $level ) );
			}
		}

		return $result;
	}


	public function getFlatParentsArray()
	{
		return ProductCategory::_parseFlatTreeParents( [ $this ], 0 );
	}



	// CUSTOM FILL
	public function fill(array $attributes)
	{
		// Main image
		if ( isset($attributes['image']) ) {
			$image = $attributes['image'];

			if ( isset($image) ) {
				if ( is_array($image) ) {
					$attributes['image'] = (count($image) > 0 ? $image[0]['id'] : null );
				} else {
					$attributes['image'] = ( substr($image, 0, 4) == 'http' ? $image : null );
				}
			} else {
				$attributes['image'] = null;
			}
		}

		return parent::fill($attributes);
	}


	public function getImageAttribute($value)
	{
		return $this->_getMediaFromValue( $value );
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


	public function getTotalProductsAttribute()
	{
		$tmp = [ $this->id ];
		$childs = $this->singleCategoryFlatTreeChildsArray( null, null );

		if ( $childs && count($childs) > 0 ) {
			foreach ( $childs as $c ) {
				$tmp[] = $c->id;
			}
		}
		
		$tmp = array_unique($tmp);
		
//		echo '<pre>';
//		print_r( join(',', $tmp) );
		// 130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,207,152,153,154,155,156,157,158,159,197,198,199
		return DB::table('product_product_category')
					->whereIn('product_category_id', $tmp)
					->count();
	}

}
