<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Media;


class UpdateController extends Controller
{

	public function update( Request $request, $id ){
		$data = $request->all();

		$this->validator( $request, $data, $id )->validate();

		$content = Content::find($id);
		$this->_save( $request, $content );

		return response()->json( [ 'status' => 'ok', 'data' => $data ]);
	}

	public function updateOld(Request $request, $id)
	{
		$data = $request->all();

		$this->validator( $request, $data, $id )->validate();

		$content = Content::find($id);
		$this->_save( $request, $content );

		if ( $request->ajax() ) {
			return response()->json([
				'result'       => 'ok',
				'redirect_url' => $content->abs_url
			]);
		} else {
			return redirect( 'admin/content/edit/' . $content->id )
						->with('message', Lang::get('factotum::content.success_update_content'));
		}
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
