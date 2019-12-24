<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Http\Requests\StoreContent;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Media;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\ContentCategory;


class Controller extends ApiBaseController
{
	protected $statuses;
	protected $_contentType;
	protected $_contentFields;
	protected $_contents;
	protected $_categories;
	protected $_contentCategories;
	protected $_additionalValues;

	protected function _save( StoreContent $request, $content )
	{
		$data = $request->all();

		$contentType = ContentType::find($content->content_type_id);

		if ( !$content->user_id ) {
			// TODO:
			// $user = Auth::user();
			$content->user_id = 1; // $user->id;
		}

		$content->status    = $data['status'];
		$content->parent_id = $request->has('parent_id') ? $request->input('parent_id') : 0;
		$content->title     = $data['title'];
		$content->url       = str_slug($data['url'], "-");
		$content->content   = $data['content'];

		print_r('teat');
		print_r($content);
		die;

		// TODO: fix
		/*if ( $data['created_at'] ) {
			$content->created_at = $data['created_at']; // U tility::convert HumanDateTimeToIso( $data['created_at'] );
		}*/

		// TODO: $request->session()->get('currentLanguage'); empty
		$content->lang = 'en-GB'; //$request->session()->get('currentLanguage');

		$content->abs_url = url('') . '/'
						  . ( $content->lang != config('factotum.main_site_language') ? $content->lang . '/' : '' )
						  . $data['url'];

		$content->show_in_menu = (isset($data['show_in_menu']) ? $data['show_in_menu'] : false );

		if ( !$content->id ) {
			$content->is_home = false;
		} else {
			$content->is_home = ( $content->is_home ? true : false );
		}



		$content->link         = '';
		$content->link_title   = '';
		$content->link_open_in = null;

		if ( $contentType->content_type == 'page' ) {
			$content->link         = $data['link'];
			$content->link_title   = $data['link_title'];
			$content->link_open_in = $data['link_open_in'];
		}

		// SEO Fields
		$content->seo_title            = $data['seo_title'] ? $data['seo_title'] : '';
		$content->seo_description      = $data['seo_description'] ? $data['seo_description'] : '';
		$content->seo_canonical_url    = $data['seo_canonical_url'] ? $data['seo_canonical_url'] : '';
		$content->seo_robots_indexing  = $data['seo_robots_indexing'] ? $data['seo_robots_indexing'] : '';
		$content->seo_robots_following = $data['seo_robots_following'] ? $data['seo_robots_following'] : '';

		// FB Fields
		$content->fb_title       = $data['fb_title'] ? $data['fb_title'] : '';
		$content->fb_description = $data['fb_description'] ? $data['fb_description'] : '';
		$content->fb_image       = (isset($data['fb_image_hidden']) && $data['fb_image_hidden'] != '' ? $data['fb_image_hidden'] : null);

		$content->save();

		// Categories
		if ( isset($data['categories']) ) {
			ContentCategory::whereContentId($content->id)->delete();

			foreach ( explode( ',' , $data['categories'] )  as $categoryID ) {
				$contentCategory = new ContentCategory;
				$contentCategory->content_id = $content->id;
				$contentCategory->category_id = $categoryID;
				$contentCategory->save();
			}
		}

		// Save Additional Fields
		$contentFields = ContentField::where( 'content_type_id', '=', $contentType->id )->get();
		if ( $contentFields->count() > 0 ) {

			$additionalValuesExists = DB::table( $contentType->content_type )
										->where( 'content_type_id', $contentType->id )
										->where( 'content_id', $content->id )
										->first();

			$additionalValues = array(
				'content_type_id' => $contentType->id,
				'content_id'      => $content->id
			);

			$this->contentDir = 'media/' . $content->id;

			foreach ( $contentFields as $field ) {

				// Multioptions fields
				if ( isset( $data[ $field->name ] ) &&
					 ($field->type == 'multicheckbox' || $field->type == 'multiselect' ) ) {
					if ( is_array($data[ $field->name ]) ) {
						$data[ $field->name ] = Utility::convertOptionsArrayToText( $data[ $field->name ] );
					}
				}

				// Date fields
				if ( isset( $data[ $field->name ] ) && $field->type == 'date' && $data[$field->name] != '' ) {
					$data[$field->name] = Utility::convertHumanDateToIso($data[$field->name]);
				}

				// Date-time fields
				if ( isset( $data[ $field->name ] ) && $field->type == 'datetime' && $data[$field->name] != '' ) {
					$data[$field->name] = Utility::convertHumanDateTimeToIso($data[$field->name]);
				}

				if ( $field->type == 'multiple_linked_categories' ) {
					if ( isset( $data[ $field->name ] ) ) {
						if ( is_array( $data[ $field->name ] ) ) {
							$data[ $field->name ] = Utility::convertOptionsArrayToText( $data[ $field->name ] );
						}
					} else {
						$additionalValues[ $field->name ] = '';
					}
				}

				$additionalValues[ $field->name ] = (isset($data[ $field->name ]) ? $data[ $field->name ] : null);
			}

			if ( $additionalValuesExists ) {
				DB::table( $contentType->content_type )
					->where( 'id', $additionalValuesExists->id )
					->update( $additionalValues );
			} else {
				DB::table( $contentType->content_type )->insert( $additionalValues );
			}

		}

		return $content;
	}


}
