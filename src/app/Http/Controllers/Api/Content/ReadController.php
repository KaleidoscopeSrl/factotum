<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Content;
use Kaleidoscope\Factotum\Models\ContentField;
use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Models\Media;


class ReadController extends ApiBaseController
{


	public function getList( Request $request, $contentTypeId )
	{
		$lang      = $request->input('lang');
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort', 'id');
		$direction = $request->input('direction', 'DESC');
		$contentId = $request->input('contentId');
		$filter    = $request->input('filter');


		$args = [
			'content_type_id' => $contentTypeId,
			'lang'            => $lang,
			'limit'           => $limit,
			'offset'          => $offset,
			'sort'            => $sort,
			'direction'       => $direction,
			'query'           => $filter,
		];

		$contentList = Content::treeChildsArray( $args );


		return response()->json( [
			'result'   => 'ok',
			'contents' => $contentList,
			'total'    => Content::getQueryCount( $args )
		]);
	}


	public function getListBySearch( Request $request, $contentTypeId )
	{
		$lang   = $request->input('lang');
		$search = $request->input('search');

		$query = Content::where('content_type_id', $contentTypeId)
						->where( 'title', 'like', '%' . $search . '%' );

		if ( $lang ) {
			$query->where( 'lang', $lang );
		}

		$contentList = $query->get();

		return response()->json( [
			'result'   => 'ok',
			'contents' => $contentList
		]);
	}


	public function getContentsByType( Request $request, $contentTypeID )
	{
		if ( $contentTypeID ) {

			$lang = $request->input('lang');

			$query = Content::where('content_type_id', '=', $contentTypeID);

			if ( $lang ) {
				$query->where( 'lang', $lang );
			}

			$contents = $query->get();

			$tmp = [];
			if ( count($contents) > 0 ) {
				foreach ( $contents as $content ) {
					$tmp[$content->id] = $content->title;
				}
			}
			return response()->json( [ 'status' => 'ok', 'data' => $tmp ]);
		}

		return response()->json( [ 'status' => 'ko' ] );
	}


	public function getDetail(Request $request, $id)
	{
		$content = Content::with('categories')->where( 'id', $id )->first();

		if ( $content ) {

			// fb image
			$tmpMedia = Media::find($content->fb_image);
			if ( $tmpMedia ) {
				$content->fb_image = [ $tmpMedia ];
			}

			$contentType   = ContentType::find( $content->content_type_id );
			$contentFields = ContentField::where( 'content_type_id', $contentType->id )->get();
			$dataContent   = DB::table( $contentType->content_type )
								->where( 'content_id',      $content->id )
								->where( 'content_type_id', $contentType->id)
								->first();


			if ( $contentType->static_content &&
				$dataContent->custom_design &&
				$dataContent->custom_content ) {

				$content->{'custom_design'}  = $dataContent->custom_design;
				$content->{'custom_content'} = $dataContent->custom_content;
			}


			if ( $contentFields && $contentFields->count() > 0 ) {

				foreach ( $contentFields as $contentField ) {

					switch ( $contentField->type ) {

						case 'image_upload':
						case 'file_upload':
							$media = null;
							if ( isset($dataContent->{$contentField->name}) && $dataContent->{$contentField->name} != null ) {
								$media = Media::find($dataContent->{$contentField->name});
							}
							$content->{$contentField->name} = ( isset( $dataContent->{$contentField->name} ) && $media ? [ $media ] : null );
						break;

						case 'gallery':
							$tmpListMedia = ( isset($dataContent->{$contentField->name}) ? $dataContent->{$contentField->name} : null );
							if ( !$tmpListMedia ) {
								$content->{$contentField->name} = '';
							} else {
								$content->{$contentField->name} = Media::whereIn( 'id', explode( ',', $tmpListMedia ) )->get();
							}
						break;

						case 'linked_content':
						case 'multiple_linked_content':
							$tmpLinkedContent = ( isset($dataContent->{$contentField->name}) ? $dataContent->{$contentField->name} : null );
							if ( !$tmpLinkedContent ) {
								$content->{$contentField->name} = '';
							} else {
								$ids = explode( ',', $tmpLinkedContent );
								$content->{$contentField->name} = Content::whereIn( 'id', $ids )->orderByRaw("FIELD(id, $tmpLinkedContent)")->get();
							}
						break;

						case 'multiselect':
							$content->{$contentField->name} = ( isset($dataContent->{$contentField->name}) ? json_decode( $dataContent->{$contentField->name} ) : '' );
						break;

						case 'checkbox':
							$content->{$contentField->name} = ( isset($dataContent->{$contentField->name}) && ($dataContent->{$contentField->name} == 1 || $dataContent->{$contentField->name} == '1') ? true : false );
						break;

						case 'datetime':
							$content->{$contentField->name} = ( isset($dataContent->{$contentField->name}) ? strtotime($dataContent->{$contentField->name}) * 1000 : '' );
						break;

						default:
							$content->{$contentField->name} = ( isset( $dataContent->{$contentField->name} ) ? $dataContent->{$contentField->name} : '' );
						break;

					}

				}

			}

			return response()->json([
				'content'    => $content
			]);
		}

		return $this->_sendJsonError( 'Content not found', 404 );
	}

}

