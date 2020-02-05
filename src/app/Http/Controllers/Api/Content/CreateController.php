<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Http\Requests\StoreContent;

class CreateController extends Controller
{

	public function create( StoreContent $request )
	{
		$data = $request->all();

		if ( !isset($data['created_at']) || !$data['created_at'] ) {
			$data['created_at'] = Carbon::now();
		}

		$user = Auth::user();

		$content = new Content();
		$content->user_id = $user->id;
		$content->is_home = false;
		$content->fill( $data );
		$content->save();

		return response()->json( [ 'status' => 'ok', 'content' => $content->toArray() ] );
	}


}

