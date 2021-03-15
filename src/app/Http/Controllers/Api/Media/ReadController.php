<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Media;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;

class ReadController extends Controller
{

	public function getList( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$rules     = $request->input('rules');

		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Media::orderBy($sort, $direction);

		if ( $rules ) {

			if ( isset($rules['max_file_size']) && $rules['max_file_size'] ) {
				$query->where( 'size', '<=', $rules['max_file_size'] * 1024 * 1024 );
			}

			if ( isset($rules['min_width_size']) && $rules['min_width_size'] ) {
				$query->where( 'width', '>=', $rules['min_width_size'] );
			}


			if ( isset($rules['min_height_size']) && $rules['min_height_size'] ) {
				$query->where( 'height', '>=', $rules['min_height_size'] );
			}

			if ( isset($rules['allowed_types']) && count($rules['allowed_types']) > 0 ) {
				if ( !in_array( '*', $rules['allowed_types'] ) ) {
					$query->where(function($q) use ($rules) {
						foreach ( $rules['allowed_types'] as $ext ) {
							$ext = strtolower( trim($ext) );
							$mimeType = \GuzzleHttp\Psr7\mimetype_from_extension($ext);
							$q->orWhere( 'mime_type', $mimeType );
						}
					});
				}
			}

		}

		$query->skip($offset)
				->take($limit);

		if ( $request->input('filter') ) {
			$query->whereRaw( 'LCASE(filename) like "%' . $request->input('filter') . '%"' );
		}

		$mediaList = $query->get();

        return response()->json( [
        	'media' => $mediaList,
			'total' => Media::count()
		]);
	}


	public function getListPaginated( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Media::query();

		if ( $request->input('filter') ) {
			$query->whereRaw( 'LCASE(filename) like "%' . $request->input('filter') . '%"' );
		}

		$total = $query->count();

		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$medias = $query->get();

		return response()->json( [ 'result' => 'ok', 'medias' => $medias, 'total' => $total ]);
	}


    public function getDetail(Request $request, $id)
    {
        $media = Media::find($id);

        $media->url = ( $media->url ? url( $media->url ) : null );

        if ( $media ) {
            return response()->json( [ 'result' => 'ok', 'media' => $media ]);
        }

        return $this->_sendJsonError( 'Media not found', 404 );
    }


	public function getImages()
	{
		$images = Media::where( 'mime_type', '=', 'image/jpeg' )
						->orWhere( 'mime_type', '=', 'image/png' )
						->orWhere( 'mime_type', '=', 'image/gif' )
						->orderBy('id','DESC')
						->get()
						->toArray();

		foreach ( $images as $i => $m ) {
			$images[$i] = $this->_parseMedia($m);
		}

		return response()->json( $images );
	}


	public function getMediaPaginated(Request $request)
	{
		$offset    = $request->input('offset');
		$fieldName = $request->input('field_name', null);

		$field = $this->_getField( $fieldName );

		if ( $field->type == 'image_upload' || $field->type == 'gallery' ) {
			$media = $this->_getImagesPaginated( $offset );
		} else {
			$media = $this->_getMediaPaginated( $offset );
		}

		foreach ( $media as $i => $m ) {
			$media[$i] = $this->_parseMedia( $m, $fieldName );
		}

		return response()->json( $media );
	}

}

