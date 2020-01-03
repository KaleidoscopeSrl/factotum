<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Kaleidoscope\Factotum\Media;

class ReadController extends Controller
{

	public function getList( Request $request )
	{

		$query = Media::orderBy('id','DESC');
 //       $pagination = Media::paginate(25);

		if ( $request->input('filter') ) {

			$filters = $request->input('filter');

			$query->where( 'filename', null );

			if ( is_array($filters) ) {
				foreach ( $filters as $ext ) {
					if ( $ext === '*' ) {
						$ext = '%';
					}
					$query->orWhereRaw( "UCASE(filename) like '%" . trim($ext) . "'" );
				}
			} else {
				foreach ( explode(',', $filters) as $ext ) {
					if ( $ext === '*' ) {
						$ext = '%';
					}
					$query->orWhereRaw( "UCASE(filename) like '%" . trim($ext) . "'" );
				}
			}

		}

		$mediaList = $query->get();


		foreach ( $mediaList as $media ){
			$media->url = ( $media->url ? url( $media->url ) : null );
		}

        return response()->json( [ 'result' => 'ok', 'media' => $mediaList ]);
	}

    public function getDetail(Request $request, $id)
    {
        $media = Media::find($id);

        $media->url = ( $media->url ? url( $media->url ) : null );

        if ( $media ) {
            return response()->json( [ 'result' => 'ok', 'media' => $media ]);
        }

        return $this->_sendJsonError('Media non trovata.');
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

