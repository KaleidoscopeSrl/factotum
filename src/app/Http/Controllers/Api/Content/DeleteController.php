<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentType;

class DeleteController extends Controller
{
	public function delete($id)
	{
		$content = Content::find($id);
		$contentType = ContentType::find( $content->content_type_id );

		DB::table( $contentType->content_type )
			->where( 'content_id', '=', $content->id)
			->delete();

		Content::destroy($id);

		return redirect( '/admin/content/list/' . $contentType->id )
					->with('message', Lang::get('factotum::content.success_delete_content'));
	}
}
