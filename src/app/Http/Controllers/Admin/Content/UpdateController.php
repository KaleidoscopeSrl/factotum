<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Content;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Media;


class UpdateController extends Controller
{
	public function edit( $id )
	{
		$content = Content::find($id);

		if ( $content->fb_image ) {
			$fbImage = Media::find($content->fb_image);
			if ($fbImage) {
				$content->fb_image = $fbImage->toArray();
			}
		}

		$this->_prepareContentFields( $content->content_type_id, $id );
		$contentType = ContentType::find( $content->content_type_id );

		return view('admin.content.edit')
					->with('content', $content)
					->with('title', Lang::get('factotum::content.edit') . ' ' . $contentType->content_type )
					->with('statuses', $this->statuses)
					->with('contentType', $contentType)
					->with('contentFields', $this->_contentFields)
					->with('contentsTree', $this->_contents)
					->with('additionalValues', $this->_additionalValues)
					->with('contentCategories', $this->_contentCategories)
					->with('postUrl', url('/admin/content/update/' . $id) )
					->with('categoriesTree', $this->_categories);
	}

	public function update(Request $request, $id)
	{
		$data = $request->all();
		$this->validator( $request, $data, $id )->validate();

		$content = Content::find($id);
		$this->_save( $request, $content );

		return redirect( 'admin/content/list/' . $content->content_type_id )
					->with('message', Lang::get('factotum::content.success_update_content'));
	}

	public function sortContents( Request $request )
	{
		$newOrder = json_decode( $request->input('new_order') );
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
