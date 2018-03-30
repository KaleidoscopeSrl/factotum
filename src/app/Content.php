<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
	public static $FIRE_EVENTS = true;

	public function parent() {
		return $this->belongsTo( 'Kaleidoscope\Factotum\Content', 'parent_id');
	}

	public function childs() {
		return $this->hasMany('Kaleidoscope\Factotum\Content','parent_id','id') ;
	}

	public function childrenRecursive()
	{
		return $this->childs()->with('childrenRecursive');
	}

	public function parentRecursive()
	{
		return $this->parent()->with('parentRecursive');
	}







	public static function treeChildsArray( $contentTypeId, $pagination = null, $language = '' )
	{
		$contents = self::_getChildContents( $contentTypeId, $pagination, $language );

		if ($contents->count() > 0) {
			$contents = self::_parseChildsTree( $contents );
		}
		return $contents->toArray();
	}


	public static function treeChildsObjects( $contentTypeId, $pagination = null, $language = '' )
	{
		$contents = self::_getChildContents( $contentTypeId, $pagination, $language );
		if ($contents->count() > 0) {
			$contents = self::_parseChildsTree( $contents );
		}
		return $contents;
	}

	private static function _getChildContents( $contentTypeId, $pagination, $language = '' )
	{
		$query = Content::where( 'content_type_id', '=', $contentTypeId )
						->whereNull( 'parent_id' )
						->orderBy('order_no', 'ASC')
						->orderBy('title', 'ASC');

		if ( $language != '' ) {
			$query->whereLang($language);
		}

		if ( $pagination ) {
			return $query->paginate($pagination);
		} else {
			return $query->get();
		}
	}

	private static function _parseChildsTree( $contents )
	{
		foreach ($contents as $c) {
			if ( $c->childs->count() > 0 ) {
				$c->childs = $c->childs->sortBy('order_no');
				$c->childs = self::_parseChildsTree($c->childs);
			}
		}
		return $contents;
	}

}
