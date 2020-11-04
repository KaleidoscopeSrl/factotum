<?php

namespace Kaleidoscope\Factotum\Library;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\CategoryContent;
use Kaleidoscope\Factotum\ContentType;

class ContentSearch {


	private $_contentType;
	private $_model;
	private $_fields;
	private $_relations;


	private $_query;
	private $_pagination;
	private $_loadCategories;


	private $_cols = [
		'contents.id', 'contents.content_type_id', 'contents.user_id', 'contents.status', 'parent_id',
		'title', 'content', 'url', 'abs_url', 'lang',
		'show_in_menu', 'is_home',
		'order_no',
		'seo_title', 'seo_description', 'seo_canonical_url', 'seo_robots_indexing', 'seo_robots_following',
		'fb_title', 'fb_description', 'fb_image',
		'contents.created_at', 'contents.updated_at',
		'profiles.first_name', 'profiles.last_name',
		'users.email', 'users.avatar'
	];


	public function __construct( $contentType )
	{
		if ( is_string($contentType) ) {
			$this->_contentType = ContentType::where('content_type', $contentType)->first()->toArray();
		} elseif ( is_array($contentType) ) {
			$this->_contentType = $contentType;
		} elseif ( $contentType instanceof ContentType ) {
			$this->_contentType = $contentType->toArray();
		}

		if ( !$this->_contentType ) {
			throw new \Exception('Content Type definition missing.');
		}

		$this->_model = json_decode( Storage::get( 'models/' . $this->_contentType['content_type'] . '.json' ) );

		$this->_fields    = (isset($this->_model->fields)    ? (array) $this->_model->fields    : [] );
		$this->_relations = (isset($this->_model->relations) ? (array) $this->_model->relations : [] );

		$this->_cols = join( ',', array_merge( $this->_cols, array_keys( $this->_fields ) ) );

		$this->_query = DB::table('contents')
							->select( DB::raw( $this->_cols ) )
							->leftJoin( $this->_contentType['content_type'], 'contents.id', '=', $this->_contentType['content_type'] . '.content_id')
							->leftJoin( 'users', 'users.id', '=', 'contents.user_id')
							->leftJoin( 'profiles', 'profiles.user_id', '=', 'users.id')
							->where( 'contents.content_type_id', '=', $this->_contentType['id']);

		$this->_loadCategories = false;

		return $this;
	}


	public function getQuery()
	{
		return $this->_query;
	}


	public function onlyPublished()
	{
		$this->_query->where( 'contents.status', '=', 'publish' );
		return $this;
	}


	public function addWhereCondition( $fieldName, $condition, $value )
	{
		if ( $fieldName == 'id' ) {
			$fieldName = 'contents.id';
		}

		if ( strtolower($condition) == 'in' ) {
			$this->_query->whereIn( $fieldName, $value );
		} else {
			$this->_query->where( $fieldName, $condition, $value );
		}

		return $this;
	}


	public function addWhereNull( $fieldName )
	{
		$this->_query->whereNull( $fieldName );
		return $this;
	}


	public function addOrderBy( $orderBy, $sort )
	{
		$this->_query->orderBy( $orderBy , $sort );
		return $this;
	}


	public function addOrderBySequence( $field, $value )
	{
		$this->_query->orderByRaw(DB::raw( 'FIELD(contents.' . $field .',' . $value . ')' ));
		return $this;
	}


	public function addLimit( $limit )
	{
		$this->_query->limit( $limit );
		return $this;
	}


	public function addOffset( $offset )
	{
		$this->_query->offset( $offset );
		return $this;
	}


	public function addPagination( $pagination )
	{
		$this->_pagination = $pagination;
		$this->_query->paginate( $pagination );
		return $this;
	}


	public function filterByCategories( $category )
	{
		$contentCategories = CategoryContent::where('category_id', '=', $category->id)->get()->toArray();
		$tmp = [];
		if ( count($contentCategories) > 0 ) {
			foreach ( $contentCategories as $contentCat ) {
				$tmp[] = $contentCat['content_id'];
			}
		}
		return $this->addWhereCondition( 'id', 'in', $tmp );
	}


	public function loadCategories( $loadCategories )
	{
		$this->_loadCategories = true;
		return $this;
	}


	public function search( $avoidDeepLinking = false )
	{
		if ( $this->_pagination ) {

			$contentListParser = new ContentListParser( $this->_model, $this->_query->paginate( $this->_pagination ), $avoidDeepLinking );

		} else {

			$contentListParser = new ContentListParser( $this->_model, $this->_query->get(), $avoidDeepLinking );

		}

		$contentListParser->loadCategories( $this->_loadCategories );

		return $contentListParser->getList();
	}

}
