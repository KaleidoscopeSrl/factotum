<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Http\Requests\StoreMedia;
use Kaleidoscope\Factotum\Media;



class UploadController extends Controller
{

	public function upload( StoreMedia $request )
	{
		$data = $request->all();

		$user = Auth::user();

		unset( $data['files'] );

		$media = new Media();
		$media->user_id = $user->id;
		$media->fill($data);
		$media->save();

		$path = $request->file('files')->storeAs( $media->id, $media->filename, 'media' );
		$webpPath = substr( $path, 0, strlen($path) - 3 ) . 'webp';

		$media->url      = 'media/' . $path;
		$media->url_webp = 'media/' . $webpPath;

		$media->save();


		if ( $media->id ) {
			if ( Str::contains( $media->mime_type, 'image/' )  ) {
				$media = Media::generateThumb( $media );
			}

			return response()->json( [ 'status' => 'ok', 'media' => $media ]);
		}

		return response()->json( [ 'status' => 'ko' ], 400);
	}


}
