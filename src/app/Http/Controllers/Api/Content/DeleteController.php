<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;

class DeleteController extends Controller
{
	public function remove(Request $request, $id)
	{
		$content = Content::find($id);

		if ( $content ) {

			$contentType = ContentType::find( $content->content_type_id );

			$deletedRows = DB::table( $contentType->content_type )
								->where( 'content_id', '=', $content->id )
								->delete();

			$deletedRows += $content->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Content not found', 404 );

	}
}
