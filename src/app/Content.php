<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Requests\StoreContent;
use Kaleidoscope\Factotum\Library\Utility;


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
		'order_no',

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
		'updated_at',
	];

	protected $casts = [
		'fb_title'       => 'string|null',
		'fb_description' => 'string|null',
		'fb_image'       => 'int|null',
	];



	public function save( array $options = [] )
	{
		$contentSaved = parent::save($options);
		$this->_saveAdditionalContent( $this );
		return $contentSaved;
	}


	private function _saveAdditionalContent( Content $content )
	{
		$data = request()->all();

		if ( count($data) > 0 ) {

			// Categories
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


				foreach ( $contentFields as $field ) {

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

		return $content;
	}





	// RELATIONS

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
