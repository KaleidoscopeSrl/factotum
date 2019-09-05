<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Content;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Library\Utility;
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

		return view('factotum::admin.content.edit')
					->with('editor', true)
					->with('content', $content)
					->with('title', Lang::get('factotum::content.edit') . ' ' . $contentType->content_type )
					->with('statuses', $this->statuses)
					->with('contentType', $contentType)
					->with('contentFields', $this->_contentFields)
					->with('contentsTree', $this->_contents)
					->with('mediaPopulated', $this->_prepareMediaPopulated( array_merge( (array)$this->_additionalValues , $content->toArray() ) ) )
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
				$content->order_no = count($newOrder) - $order;
				$content->save();
			}
			return response()->json( [ 'status' => 'ok' ]);
		} else {
			return response()->json( [ 'status' => 'ko' ]);
		}
	}
}
