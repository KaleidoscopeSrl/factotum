<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

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

	protected function _prepareMediaPopulated($content)
	{
		$tmp = [];

		if ( $this->_contentFields->count() > 0 ) {
			foreach ( $this->_contentFields as $cf ) {

				if ( isset($content[$cf['name']]) && ( $cf['type'] == 'image_upload' || $cf['type'] == 'file_upload' ) ) {

					$tmp[$cf['name']] = $this->_parseMedia( $content[$cf['name']], $cf['name'] );

				} elseif ( isset($content[$cf['name']]) && $cf['type'] == 'gallery' ) {

					foreach ( $content[$cf['name']] as $i => $m ) {
						$content[$cf['name']][$i] = $this->_parseMedia( $m, $cf['name'] );
					}
					$tmp[$cf['name']] = $content[$cf['name']];

				}
			}
		}

		if ( $content['fb_image'] ) {
			$tmp['fb_image'] = $this->_parseMedia( $content['fb_image'], 'fb_image' );
		}

		return $tmp ;
	}

	protected function _prepareContentFields( $contentTypeID, $contentID = null )
	{
		$this->statuses = array(
			'draft' => Lang::get('factotum::content.draft')
		);

		if ( $this->guard()->user()->canPublish( $contentTypeID) ) {
			$this->statuses = array(
				'publish' => Lang::get('factotum::content.publish'),
				'draft'   => Lang::get('factotum::content.draft'),
			);
		}

		$this->_contentType   = ContentType::find( $contentTypeID );
		$this->_contents      = Content::treeChildsArray( $this->_contentType->id, null, $this->currentLanguage, $contentID );
		$this->_categories    = Category::treeChildsArray( $this->_contentType->id );
		$this->_contentFields = ContentField::where( 'content_type_id', '=', $contentTypeID )
											->orderBy('order_no', 'asc')
											->get();

		if ( $contentID ) {
			$this->_additionalValues = DB::table( $this->_contentType->content_type )
												->where( 'content_type_id', $this->_contentType->id )
												->where( 'content_id', $contentID )
												->first();
			$contentCategories = ContentCategory::whereContentId( $contentID )->get()->toArray();
			$tmp = array();
			if ( count($contentCategories) > 0 ) {
				foreach ( $contentCategories as $cc ) {
					$tmp[] = $cc['category_id'];
				}
			}
			$this->_contentCategories = $tmp;
		}

		if ( $this->_contentFields->count() > 0 ) {
			foreach ( $this->_contentFields as $field ) {
				if ( $contentID ) {

					if ( $field->type == 'file_upload' || $field->type == 'image_upload' ) {
						if ( isset($this->_additionalValues->{$field->name}) ) {
							$media = Media::find( $this->_additionalValues->{$field->name} );
							if ( $media ) {
								$this->_additionalValues->{$field->name} = $media->toArray();
							}
						}
					} else if ( $field->type == 'gallery' ) {

						if ( isset($this->_additionalValues->{$field->name}) ) {
							$media = Media::findMany( Utility::convertOptionsTextToArray( $this->_additionalValues->{$field->name} ) );
							if ( $media ) {
								$this->_additionalValues->{$field->name} = $media->toArray();
							}
						}
					}

				}

				if ( $field->type == 'linked_content' || $field->type == 'multiple_linked_content' ) {
					$field->options = Content::treeChildsArray( $field->linked_content_type_id );
				}

				if ( $field->name == 'content_type_to_list' ) {
					$options = ContentType::where('content_type', '<>', 'page')->get();
					$tmp = array(
						'null:Select content type'
					);
					foreach ( $options as $opt ) {

						$tmp[] = $opt->id . ':' . $opt->content_type;
					}
					$tmp = join(';', $tmp);
					$field->options = $tmp;
				}

				if ( $field->type == 'multiple_linked_categories' ) {
					$field->options = Category::treeChildsArray( $contentTypeID );
				}
			}
		}


	}


	protected function _save( Request $request, $content )
	{
		$data = $request->all();

		$contentType = ContentType::find($content->content_type_id);

		if ( !$content->user_id ) {
			$user = Auth::user();
			$content->user_id = $user->id;
		}

		$content->status    = $data['status'];
		$content->parent_id = (isset($data['parent_id']) ? $data['parent_id'] : null);
		$content->title     = $data['title'];
		$content->url       = $data['url'];
		$content->content   = $data['content'];

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
		$content->seo_title            = $data['seo_title'];
		$content->seo_description      = $data['seo_description'];
		$content->seo_canonical_url    = $data['seo_canonical_url'];
		$content->seo_robots_indexing  = $data['seo_robots_indexing'];
		$content->seo_robots_following = $data['seo_robots_following'];

		// FB Fields
		$content->fb_title       = $data['fb_title'];
		$content->fb_description = $data['fb_description'];
		$content->fb_image       = (isset($data['fb_image_hidden']) && $data['fb_image_hidden'] != '' ? $data['fb_image_hidden'] : null);

		$content->save();

		// Categories
		if ( isset($data['categories']) && count($data['categories']) > 0 ) {
			ContentCategory::whereContentId($content->id)->delete();

			foreach ( $data['categories'] as $categoryID ) {
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

				// Date-time fields
				if ( isset( $data[ $field->name ] ) && $field->type == 'date' && $data[$field->name] != '' ) {
					$data[$field->name] = Utility::convertHumanDateToIso($data[$field->name]);
				}

				if ( isset( $data[ $field->name ] ) && $field->type == 'datetime' && $data[$field->name] != '' ) {
					$data[$field->name] = Utility::convertHumanDateTimeToIso($data[$field->name]);
				}

				// Save generic file upload (file or image)
				$file = null;
				if ( $field->type == 'file_upload' || $field->type == 'image_upload' ) {
					if ($request->hasFile( $field->name )) {
						if ($request->file( $field->name )->isValid()) {
							$file = $request->file( $field->name );
							$data[ $field->name ] = '';
							$data[ $field->name ] = $this->_saveMedia( $file, $field );
						}
					} else {
						if ( isset($data[ $field->name . '_hidden' ]) ) {
							$data[ $field->name ] = $data[ $field->name . '_hidden' ];
							$data[ $field->name ] = $this->_checkImage( $data[ $field->name ], $field );
						} else {
							$data[ $field->name ] = '';
						}
					}
				}

				if ( $field->type == 'gallery' ) {
					$tmp = array();

					if ( isset( $data[ $field->name . '_hidden' ] ) && $data[ $field->name . '_hidden' ] != '' ) {
						$tmp = Utility::convertOptionsTextToArray( $data[ $field->name . '_hidden' ] );
					}

					if ($request->hasFile( $field->name )) {
						$files = $request->file( $field->name );
						if ( count($files) > 0 ) {
							foreach ( $files as $file ) {
								if ( $file->isValid() ) {
									$tmp[] = $this->_saveMedia( $file, $field );
								}
							}
							$data[ $field->name ] = join(';', $tmp);
						}

					} else {
						if ( isset($data[ $field->name . '_hidden' ]) ) {
							$data[ $field->name ] = $data[ $field->name . '_hidden' ];
							$files = explode(';', $data[ $field->name ]);
							$tmp2 = [];
							foreach ( $files as $file ) {
								$tmp2[] = $this->_checkImage( $file, $field );
							}
							$data[ $field->name ] = join(';', $tmp2);
						} else {
							$data[ $field->name ] = '';
						}
					}
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

	private function _checkImage( $mediaId, $field )
	{
		$media = Media::find($mediaId);
		if ( Media::checkImageSizesNotExist( $field, $media ) ) {
			Media::saveImage( $field, $media->url );
		}
		return $mediaId;
	}

	private function _saveMedia( $file, $field )
	{
		$filename = $file->getClientOriginalName();
		$filename = Media::filenameAvailable($filename, $filename);

		$media = new Media;
		$media->filename  = $filename;
		$media->mime_type = $file->getMimeType();
		$media->save();

		$mediaDir = 'media/' . $media->id;
		Storage::makeDirectory( $mediaDir );

		$path = $file->storeAs( $mediaDir, $filename );

		$media->url = $path;
		$media->save();

		if ( $file && ( $field->type == 'image_upload' || $field->type == 'gallery' ) ) {
			Media::saveImage( $field, $media->url );
		}

		return $media->id;
	}


	protected function validator(Request $request, array $data, $id = null)
	{
		$rules = array(
			'title'   => 'required',
			'url'     => 'required',
			'status'  => 'required'
		);

		if ($id) {
			$content = Content::find($id);
			if ( $data['url'] != $content->url ) {
				$alreadyExist = Content::where('url', '=', $data['url'])
									   ->where( 'content_type_id', '=', $content->content_type_id )
									   ->count();
				if ($alreadyExist > 0) {
					$rules['url'] .= '|unique:contents';
				}
			}

			$contentFields = ContentField::where( 'content_type_id', '=', $content->content_type_id )->get();

		} else {
			$rules['content_type_id'] = 'required';

			$alreadyExist = Content::where('url', '=', $data['url'])
								   ->where( 'content_type_id', '=', $data['content_type_id'] )
								   ->count();
			if ($alreadyExist > 0) {
				$rules['url'] .= '|unique:contents';
			}

			$contentFields = ContentField::where( 'content_type_id', '=', $data['content_type_id'] )->get();
		}


		// Additional Fields
		if ( $contentFields->count() > 0 ) {
			foreach ( $contentFields as $field ) {
				$tmp = array();

				if ( $field->mandatory ) {

					if (count($data) > 0 && ( $field->type == 'file_upload' || $field->type == 'image_upload'  || $field->type == 'gallery' )) {
						if ( !isset($data[ $field->name . '_hidden' ]) ||
							 (isset($data[ $field->name . '_hidden' ]) && $data[ $field->name . '_hidden' ] == '' ) ) {
							$tmp[] = 'required';
						}
					} else {
						$tmp[] = 'required';
					}
				}

				if ( $field->type == 'file_upload' || $field->type == 'image_upload' || $field->type == 'gallery' ) {
					$tmp[] = 'max:' . $field->max_file_size;
					if ($field->allowed_types != '*') {
						$field->allowed_types = str_replace('jpg', 'jpeg', $field->allowed_types);
						$field->allowed_types = str_replace('.', '', $field->allowed_types);
						$tmp[] = 'mimes:' . $field->allowed_types;
					}
				}

				if ( $field->type == 'image_upload' || $field->type == 'gallery' ) {
					$tmp[] = 'dimensions:min_width=' . $field->min_width_size . ',min_height=' . $field->min_height_size;
				}


				if ( $field->type == 'gallery' && $request->file( $field->name ) ) {
					$nbr = count( $request->file( $field->name ) ) - 1;
					foreach(range(0, $nbr) as $index) {
						$rules[ $field->name .  '.' . $index ] = join( '|', $tmp );
					}
				} else {
					$rules[ $field->name ] = join( '|', $tmp );
				}

			}
		}

		return Validator::make($data, $rules);
	}
}
