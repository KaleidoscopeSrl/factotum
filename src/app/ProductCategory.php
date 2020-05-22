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
		$categories = self::_getChildCategories( $pagination, $filters );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseChildsTree( $categories );
		}

		return $categories->toArray();
	}


	public static function treeChildsObjects( $pagination = null, $filters = null )
	{
		$categories = self::_getChildCategories( $pagination, $filters );

		if ( $categories->count() > 0 ) {
			$categories = self::_parseChildsTree( $categories );
		}

		return $categories;
	}


	private static function _getChildCategories( $pagination = null, $filters = null )
	{
		$query = ProductCategory::whereNull( 'parent_id' )->orderBy('order_no');

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
		$categories = self::_getChildCategories( $pagination, $filters );

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


	// CUSTOM FILL
	public function fill(array $attributes)
	{
		if ( isset($attributes['image']) ) {
			$image = $attributes['image'];

			// Main image
			if ( isset($image) && is_array($image) && count($image) > 0 ) {
				$attributes['image'] = $image[0]['id'];
			} else {
				$attributes['image'] = ( substr($image, 0, 4) == 'http' ? $image : null );
			}
		}


		if ( isset($attributes['icon']) ) {
			$icon  = $attributes['icon'];

			// Icon
			if ( isset($icon) && is_array($icon) && count($icon) > 0 ) {
				$attributes['icon'] = $icon[0]['id'];
			} else {
				$attributes['icon'] = ( substr($icon, 0, 4) == 'http' ? $icon : null );
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
