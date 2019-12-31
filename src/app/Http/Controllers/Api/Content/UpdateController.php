<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Http\Requests\StoreContent;


class UpdateController extends Controller
{

	public function update( StoreContent $request, $id ){
		$data = $request->all();

		$content = Content::find($id);
		$content->fill( $data );
		$content->save();

		$this->_saveContent( $request, $content );

		return response()->json( [ 'status' => 'ok', 'data' => $data ]);
	}

	public function sortContents( Request $request )
	{
		$newOrder = json_decode( $request->input('new_order'), true );
		if ( count($newOrder) > 0 ) {
			foreach ( $newOrder as $contentID => $order ) {
				$content = Content::find($contentID);
				Content::$FIRE_EVENTS = false;
				$content->order_no = $order;
				$content->save();
			}
			return response()->json( [ 'status' => 'ok' ]);
		} else {
			return response()->json( [ 'status' => 'ko' ]);
		}
	}
}
