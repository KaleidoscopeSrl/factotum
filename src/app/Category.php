<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [
		'content_type_id',
		'parent_id',
		'name',
		'label',
		'lang'
	];


	public function content_type() {
		return $this->belongsTo('Kaleidoscope\Factotum\ContentType');
	}


	public function contents()
	{
		return $this->belongsToMany('Kaleidoscope\Factotum\Content');
	}


	public function parent() {
		return $this->belongsTo( 'Kaleidoscope\Factotum\Category', 'parent_id');
	}


	public function childs() {
		return $this->hasMany('Kaleidoscope\Factotum\Category','parent_id','id') ;
	}


	public function childrenRecursive()
	{
		return $this->childs()->with('childrenRecursive');
	}


	public function parentRecursive()
	{
		return $this->parent()->with('parentRecursive');
	}




	public static function treeChildsArray( $contentTypeId, $pagination = null, $language = ''  )
	{
		$categories = self::_getChildCategories( $contentTypeId, $pagination, $language );

		if ($categories->count() > 0) {
			$categories = self::_parseChildsTree( $categories );
		}
		return $categories->toArray();
	}


	public static function treeChildsObjects( $contentTypeId, $pagination = null, $language = '' )
	{
		$categories = self::_getChildCategories( $contentTypeId, $pagination, $language );
		if ($categories->count() > 0) {
			$categories = self::_parseChildsTree( $categories );
		}
		return $categories;
	}


	private static function _getChildCategories( $contentTypeId, $pagination, $language = '' )
	{
		$query = Category::where( 'content_type_id', '=', $contentTypeId )
						->whereNull( 'parent_id' )
						->orderBy('order_no');

		if ( $language != '' ) {
			$query->where( 'lang', $language );
		}

		if ( $pagination ) {
			return $query->paginate($pagination);
		} else {
			return $query->get();
		}
	}


	private static function _parseChildsTree( $categories )
	{
		foreach ($categories as $c) {
			if ( $c->childs->count() > 0 ) {
				$c->childs = self::_parseChildsTree($c->childs);
			}
		}
		return $categories;
	}

}
