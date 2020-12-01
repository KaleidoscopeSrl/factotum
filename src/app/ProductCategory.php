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


	public static function treeChildsArray( $pagination = null, $filters = null )
	{
		$categories = self::_getChildCategories( null, $pagination, $filters );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseChildsTree( $categories );
		}

		return $categories->toArray();
	}


	public static function treeChildsObjects( $pagination = null, $filters = null )
	{
		$categories = self::_getChildCategories( null, $pagination, $filters );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseChildsTree( $categories );
		}

		return $categories;
	}


	private static function _getChildCategories( $category = null, $pagination = null, $filters = null )
	{
		if ( $category ) {
			$query = ProductCategory::where( 'id', $category->id )->orderBy('order_no', 'ASC');
		} else {
			$query = ProductCategory::whereNull( 'parent_id' )->orderBy('order_no', 'ASC');
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


	public static function flatTreeChildsArray( $pagination = null, $filters = null )
	{
		$categories = self::_getChildCategories( null, $pagination, $filters );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseFlatTreeChilds( $categories );
		}

		return $categories;
	}


	public function singleCategoryFlatTreeChildsArray( $pagination = null, $filters = null )
	{
		$categories = self::_getChildCategories( $this, $pagination, $filters );

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

			if ( $parent ) {
				$absUrl = $parent->abs_url . '/' . $c->name;
			} else {
				$absUrl = '/' . $c->name;
			}

			DB::raw('UPDATE product_categories SET abs_url = ? WHERE id = ?', [ $absUrl, $c->id ]);

			if ( $childs ) {
				$level = $level + 1;
				self::_rewriteChildsAbsUrl($childs, $level, $c);
			}
		}

	}


	public function save( $options = [] )
	{
		ProductCategory::_rewriteChildsAbsUrl( [ $this ], 0 );

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

	public function getAbsUrlAttribute( $value )
	{
		return $value;
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

		return DB::table('product_product_category')
					->whereIn('product_category_id', $tmp)
					->count();
	}

}
