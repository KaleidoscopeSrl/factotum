<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Models\Media;

class DeleteController extends Controller
{
	public function remove(Request $request, $mediaID)
	{
		$media = Media::find($mediaID);

		if ( $media ) {
			if ( Storage::disk('media')->exists( $media->id ) ) {
				$deleted = Storage::disk('media')->deleteDirectory( $media->id );
				if ( $deleted ) {
					$result = Media::destroy( $media->id );

					if ( $result ) {
						return response()->json( ['result' => 'ok' ] );
					}
				}
			}
		}

		return response()->json( ['result' => 'ko' ], 422 );
	}

}
