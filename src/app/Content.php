<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
	public static $FIRE_EVENTS = true;

	protected $fillable = [
		'parent_id', 'user_id', 'content_type_id',
		'status',
		'title',
		'content',
		'url',
		'lang',
		'abs_url',

		'show_in_menu',
		'is_home',

		'link',
		'link_title',
		'link_open_in',

		'seo_title',
		'seo_description',
		'seo_canonical_url',
		'seo_robots_indexing',
		'seo_robots_following',
		'seo_focus_key',

		'fb_title',
		'fb_description',
		'fb_image',

		'created_at',
	];

	protected $casts = [
//		'show_in_menu'   => 'boolean',
//		'is_home'        => 'boolean',

		'fb_title'       => 'string|null',
		'fb_description' => 'string|null',
		'fb_image'       => 'int|null',
	];


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


	public function user() {
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'user_id');
	}


	public function categories()
	{
		return $this->belongsToMany('Kaleidoscope\Factotum\Category');
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
						->orderBy('order_no', 'DESC')
						->orderBy('id', 'DESC');

		if ( $language != '' ) {
			$query->where( 'lang', $language );
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
				$c->childs = $c->childs->sortByDesc('order_no');
				$c->childs = self::_parseChildsTree($c->childs);
			}
		}
		return $contents;
	}


	// MUTATORS
	public function getCreatedAtAttribute($value)
	{
		return ( $value ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->timestamp * 1000 : null );
	}

	public function getUpdatedAtAttribute($value)
	{
		return ( $value ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->timestamp * 1000 : null );
	}


}
