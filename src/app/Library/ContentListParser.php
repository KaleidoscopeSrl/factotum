<?php

namespace Kaleidoscope\Factotum\Library;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\ContentCategory;
use Kaleidoscope\Factotum\Media;

class ContentListParser {

	private $_model;
	private $_contentList;
	private $_fields;
	private $_relations;
	private $_avoidDeepLinking;
	private $_loadCategories;

	public function __construct( $model, $contentList )
	{
		$this->_model       = $model;
		$this->_fields      = (isset($this->_model->fields) ? (array) $this->_model->fields : array() );
		$this->_relations   = (isset($this->_model->relations) ? (array) $this->_model->relations : array());
		$this->_contentList = $contentList;
		$this->_avoidDeepLinking = false;
	}

	public function enableAvoidDeepLinking()
	{
		$this->_avoidDeepLinking = true;
	}

	public function loadCategories( $loadCategories )
	{
		$this->_loadCategories = $loadCategories;
	}

	private function _listNeededParsing()
	{
		if ( count( $this->_fields ) > 0 ) {
			foreach ( $this->_fields as $fieldName => $field ) {
				if ( isset($field->need_parsing) ) {
					return true;
				}
			}
		}
		return false;
	}

	public function getList()
	{
		if ( !$this->_listNeededParsing() ) {
			return $this->_contentList;
		} else {

			if ( $this->_contentList->count() > 0 ) {

				$tmpIDs = array();

				foreach ( $this->_contentList as $index => $content ) {

					if ( $content && $content->fb_image ) {
						$fbImage = Media::find($content->fb_image);
						if ($fbImage) {
							$content->fb_image = $fbImage->toArray();
						}
					}

					foreach ( $this->_fields as $fieldName => $field ) {

						if ( $field->type == 'file_upload' ) {
							$content->{$fieldName} = $this->_getFileData( $content->{$fieldName} );
						}

						if ( $field->type == 'image_upload' ) {
							$content->{$fieldName} = $this->_getImageData( $content->{$fieldName}, $field );
						}

						if ( $field->type == 'gallery' ) {
							$content->{$fieldName} = $this->_getGalleryData( $content->{$fieldName}, $field );
						}

						if ( $field->type == 'linked_content' && !$this->_avoidDeepLinking ) {
							$content->{$fieldName} = $this->_getLinkedContentData( $content->{$fieldName}, $field );
						}

						if ( $field->type == 'multiple_linked_content' && !$this->_avoidDeepLinking ) {
							$content->{$fieldName} = $this->_getMultipleLinkedContentData( $content->{$fieldName}, $field );
						}

					}

					$this->_contentList[ $index ] = $content;
					$tmpIDs[] = $content->id;
				}

				// LOAD CATEGORIES WHERE NEEDED
				if ( $this->_loadCategories && count($tmpIDs) > 0 ) {
					$contentCategories = ContentCategory::whereIn('content_id', $tmpIDs )->get()->toArray();
					$tmp = array();
					$tmpIDs = array();
					if ( count($contentCategories) > 0 ) {
						foreach ( $contentCategories as $cc ) {
							$tmp[ $cc['content_id'] ][] = $cc['category_id'];
							$tmpIDs[] = $cc['category_id'];
						}

						$categories = Category::whereIn('id', $tmpIDs )->get()->toArray();
						$tmpCats = array();
						foreach ( $categories as $index => $c ) {
							$tmpCats[$c['id']] = $c;
						}
						foreach ( $tmp as $contentId => $cc ) {
							foreach ( $cc as $i => $cId ) {
								$tmp[ $contentId ][ $i ] = $tmpCats[ $cId ];
							}
						}
						if ( count($this->_contentList) > 0 ) {
							foreach ( $this->_contentList as $index => $content ) {
								$this->_contentList[$index]->categories = $tmp[$content->id];
							}
						}
					}
				}

				return $this->_contentList;
			}
		}
	}


	private function _getFileData($value)
	{
		return ( $value ? Media::find( $value )->toArray() : null );
	}

	private function _getImageData($value, $fieldModel)
	{
		return ( $value ? Media::retrieve( $value, $fieldModel ) : null );
	}

	private function _getGalleryData($value, $fieldModel)
	{
		if ( $value != '' && !is_array($value) ) {
			$mediaIDs = explode(';', $value);
			$tmp = array();
			foreach ($mediaIDs as $id) {
				$tmp[] = Media::retrieve($id, $fieldModel);
			}
			return $tmp;
		}
		return $value;
	}

	private function _getLinkedContentData($value, $fieldModel)
	{
		if ( $value != '' && !($value instanceof \stdClass) ) {
			$contentSearch = new ContentSearch( (array) $fieldModel->linked_content_type );
			$contentSearch->addWhereCondition( 'id', '=', $value );
			$subContentList = $contentSearch->search();
			if ( $subContentList && $subContentList->count() > 0 ) {
				$model = json_decode( Storage::get( 'models/' . $fieldModel->linked_content_type->content_type . '.json' ) );
				$clp = new ContentListParser( $model, $subContentList );
				$clp->enableAvoidDeepLinking();
				return $clp->getList()[0];
			}
		}
	}

	private function _getMultipleLinkedContentData($value, $fieldModel)
	{
		if ( $value != '' && !($value instanceof Collection)  ) {
			$contentIDs = explode(';', $value);
			$contentSearch = new ContentSearch( (array) $fieldModel->linked_content_type);
			$contentSearch->addWhereCondition('id', 'in', $contentIDs);
			$contentSearch->addOrderBy('order_no', 'asc');
			$subContentList = $contentSearch->search();

			if ( $subContentList && $subContentList->count() > 0 ) {
				$model = json_decode( Storage::get( 'models/' . $fieldModel->linked_content_type->content_type . '.json' ) );
				$clp = new ContentListParser( $model, $subContentList );
				$clp->enableAvoidDeepLinking();
				return $clp->getList();
			}
		}
	}
}