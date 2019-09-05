<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Media;

class UpdateController extends Controller
{
	public function edit( $id )
	{
		$media = Media::find($id);

		return view('factotum::admin.media.edit')
				->with('media', $media)
				->with('title', Lang::get('factotum::media.edit_media'))
				->with('postUrl', url('/admin/media/update/' . $id ) );
	}

	public function update(Request $request, $id)
	{
		$data = $request->all();
		$this->validator( $request, $data )->validate();

		$media = Media::find($id);
		$media = $this->_save( $request, $media );

		return redirect('admin/media/list')->with('message', Lang::get('factotum::media.success_update_media'));
	}

}
