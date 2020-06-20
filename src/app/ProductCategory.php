<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Response;

class ProductCategory extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'parent_id',
		'name',
		'label',
		'lang',
		'image',
		'icon',
		'description',
		'order_no'
	];

	protected $hidden = [
		'created_at', 'updated_at', 'deleted_at'
	];

	public function products()
	{
		return $this->belongsToMany('Kaleidoscope\Factotum\Product');
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
			$query = ProductCategory::where( 'id', $category->id )->orderBy('order_no');
		} else {
			$query = ProductCategory::whereNull( 'parent_id' )->orderBy('order_no');
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


	private static function _parseFlatTreeChilds( $categories, $level = 0 )
	{
		$result = [];

		foreach ( $categories as $c ) {

			$childs = null;
			if ( $c->childs->count() > 0 ) {
				$childs = $c->childs;
			}

			unset($c->childs);

			$c->label = str_repeat('-', $level) . $c->label;

			$result[] = $c;

			if ( $childs ) {
				$level = $level + 1;
				$result = array_merge( $result, self::_parseFlatTreeChilds($childs, $level) );
			}
		}

		return $result;
	}


	public function getFlatChildsArray()
	{
		return ProductCategory::_parseFlatTreeChilds( [ $this ], 0 );
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

		// Icon
		if ( isset($attributes['icon']) ) {
			$icon  = $attributes['icon'];

			if ( isset($icon) ) {
				if ( is_array($icon) ) {
					$attributes['icon'] = (count($icon) > 0 ? $icon[0]['id'] : null );
				} else {
					$attributes['icon'] = ( substr($icon, 0, 4) == 'http' ? $icon : null );
				}
			} else {
				$attributes['icon'] = null;
			}
		}


		return parent::fill($attributes);
	}


	public function getImageAttribute($value)
	{
		return $this->_getMediaFromValue( $value );
	}


	public function getIconAttribute($value)
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

}
