<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Requests\StoreContent;
use Kaleidoscope\Factotum\Library\Utility;


class Content extends Model
{

	public static $FIRE_EVENTS = true;


	protected $fillable = [
		'parent_id',
		'user_id',
		'content_type_id',
		'status',
		'title',
		'content',
		'url',
		'lang',
		'abs_url',

		'show_in_menu',
		'is_home',
		'order_no',

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
		'updated_at',
	];


	protected $casts = [
		'fb_title'       => 'string',
		'fb_description' => 'string',
		'fb_image'       => 'int',
	];



	public function save( array $options = [] )
	{
		$contentSaved = parent::save($options);

		$this->_saveAdditionalContent( $this );

		return $contentSaved;
	}


	protected function _saveAdditionalContent( Content $content )
	{
		$data = request()->all();

		if ( count($data) > 0 ) {

			// Save Categories
			if ( isset($data['categories']) ) {
				CategoryContent::where( 'content_id', $content->id )->delete();

				foreach ( $data['categories'] as $categoryID ) {
					$categoryContent = new CategoryContent;
					$categoryContent->content_id  = $content->id;
					$categoryContent->category_id = $categoryID;
					$categoryContent->save();
				}
			}

			// Save Additional Fields
			if ( isset($data['content_type_id']) ) {

				$contentType   = ContentType::find($data['content_type_id']);
				$contentFields = ContentField::where( 'content_type_id', '=', $content->content_type_id )->get();

				if ( $contentType && $contentFields->count() > 0 ) {

					$additionalValuesExists = DB::table( $contentType->content_type )
												->where( 'content_type_id', $contentType->id )
												->where( 'content_id', $content->id )
												->first();

					$additionalValues = array(
						'content_type_id' => $contentType->id,
						'content_id'      => $content->id
					);


					if ( $contentType->static_content &&
						isset( $data['custom_design'] ) &&
						isset( $data['custom_content'] ) )
					{
						$additionalValues[ 'custom_design' ]  = $data['custom_design'];
						$additionalValues[ 'custom_content' ] = $data['custom_content'];
					}


					foreach ( $contentFields as $field ) {

						// Multiselect
						if ( isset( $data[ $field->name ] ) && $field->type == 'multiselect' && $data[$field->name] != '' ) {
							$data[$field->name] = json_encode($data[$field->name]);
						}

						// Date fields
						if ( isset( $data[ $field->name ] ) && $field->type == 'date' && $data[$field->name] != '' ) {
							$data[$field->name] = Utility::convertHumanDateToIso($data[$field->name]);
						}

						// Date-time fields
						if ( isset( $data[ $field->name ] ) && $field->type == 'datetime' && $data[$field->name] != '' ) {
							$data[$field->name] = Utility::convertHumanDateTimeToIso($data[$field->name]);
						}

						// Image Operation
						if ( $field->type == 'image_upload' && isset( $data[ $field->name ] ) ) {
							Media::saveImageById( $field, $data[ $field->name ] );
						}

						// Gallery Operation
						if ( $field->type == 'gallery' && isset( $data[ $field->name ] ) ) {
							$gallery = explode( ',', $data[ $field->name ] );
							foreach ( $gallery as $g ) {
								Media::saveImageById( $field, $g );
							}
						}

						$additionalValues[ $field->name ] = (isset($data[ $field->name ]) ? $data[ $field->name ] : null);

					}

					if ( $additionalValuesExists ) {
						DB::table( $contentType->content_type )
							->where( 'id', $additionalValuesExists->id )
							->update( $additionalValues );
					} else {
						DB::table( $contentType->content_type )
							->insert( $additionalValues );
					}

				}

			}

		}

		return $content;
	}





	// RELATIONS

	public function parent() {
		return $this->belongsTo( 'Kaleidoscope\Factotum\Models\Content', 'parent_id');
	}


	public function childs() {
		return $this->hasMany('Kaleidoscope\Factotum\Models\Content','parent_id','id')
					->with('user.profile')
					->with('categories');
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
		return $this->hasOne('Kaleidoscope\Factotum\Models\User', 'id', 'user_id');
	}


	public function categories()
	{
		return $this->belongsToMany('Kaleidoscope\Factotum\Models\Category');
	}


	protected static function getQuery( $args )
	{
		$query = Content::whereNull( 'parent_id' );

		if ( isset($args['content_type_id']) ) {
			$query->where( 'content_type_id', $args['content_type_id'] );
		}

		if ( isset($args['lang']) ) {
			$query->where( 'lang', $args['lang'] );
		}

		if ( isset($args['limit']) ) {
			$query->take( $args['limit'] );
		}

		if ( isset($args['offset']) ) {
			$query->skip( $args['offset'] );
		}

		if ( isset($args['sort']) || isset($args['direction']) ) {
			$query->orderBy( $args['sort'], $args['direction'] );
		}

		if ( isset($args['exclude']) ) {
			$query->whereNotIn( 'id', $args['exclude'] );
		}

		if ( isset($args['query']) ) {
			$query->where( 'title', 'like', '%' . $args['query'] . '%' );
		}

		return $query;
	}


	public static function getQueryCount( $args )
	{
		$q = self::getQuery( $args );
		return $q->count();
	}


	protected static function _getChildContents( $args )
	{
		$query = self::getQuery( $args );
		$query->with('user.profile')->with('categories');

		return $query->get();
	}


	public static function treeChildsArray( $args )
	{
		$contents = self::_getChildContents( $args );

		if ( $contents->count() > 0 ) {
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


	protected static function _parseChildsTree( $contents )
	{
		foreach ( $contents as $c ) {
			if ( $c->childs->count() > 0 ) {
				$c->childs = $c->childs->sortByDesc('order_no');
				$c->childs = self::_parseChildsTree($c->childs);
			}
		}
		return $contents;
	}


	private static function _parseFlatTreeParents( $contents, $level = 0 )
	{
		$result = [];
		foreach ( $contents as $c ) {

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
		return Content::_parseFlatTreeParents( [ $this ], 0 );
	}


	// MUTATORS
	public function getCreatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}

	public function getUpdatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}


}
