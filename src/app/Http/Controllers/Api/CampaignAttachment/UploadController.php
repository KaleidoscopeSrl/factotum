<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignAttachment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;

use Kaleidoscope\Factotum\CampaignAttachment;


class UploadController extends Controller
{

	public function upload(Request $request, $id)
	{
		$this->_validate( $request );

		$campaignAttachment = new CampaignAttachment;

		$path = $request->file('files')->storeAs(
			'attachments/' . $id , $request->file('files')->getClientOriginalName()
		);

		$path = storage_path($path);

		$ext      = File::extension( $path );
		$filename = File::name( $path );

		$campaignAttachment->campaign_template_id = $id;
		$campaignAttachment->filename             = $request->file('files')->getClientOriginalName();

		// CHECK IF IMAGE
		if ( in_array($ext, config('app.imageMimes')) ) {

			$imgPath   = storage_path('app/public/attachments/' . $id . '/' . $filename . '.' . $ext);
			$thumbPath = storage_path('app/public/attachments/' . $id . '/' . $filename . '_thumb.' . $ext);

			$img = Image::make($imgPath);
			$img->resize(2048, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->save();

			$img = Image::make( $imgPath );
			$img->fit( 1024, 1024 );
			$img->save( $thumbPath );

			$campaignAttachment->thumb = $filename . '_thumb.' . $ext;
		}

		$campaignAttachment->save();

		return response()->json( [ 'result' => 'ok', 'campaign_attachment'  => $campaignAttachment->toArray() ] );
	}

}


