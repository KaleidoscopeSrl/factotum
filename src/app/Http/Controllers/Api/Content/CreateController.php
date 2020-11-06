<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Http\Requests\StoreContent;
use Kaleidoscope\Factotum\Library\ContentSearch;
use Kaleidoscope\Factotum\Media;

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

		return response()->json( [ 'status' => 'ok', 'content' => $content ] );
	}


	public function duplicate( Request $request, $contentId )
	{
		$content    = Content::find( $contentId );

		$title  = substr( $content->title . ' clone', 0, 255);
		$url    = substr( $content->url . '-clone', 0, 191);
		$absUrl = substr( $content->abs_url . '-clone', 0, 191);

		$contentExist = Content::where('url', $url)->first();

		if ( $contentExist ) {
			$title  .= '_' . Str::random(5);
			$url    .= '_' . Str::random(5);
			$absUrl .= '_' . Str::random(5);
		}

		$contentType   = ContentType::find($content->content_type_id);
		$contentSearch = new ContentSearch( $contentType->content_type );
		$contentSearch->loadCategories( true );
		$contentSearch->addWhereCondition('id', '=', $contentId );
		$content = $contentSearch->search();

		if ( $content->count() > 0 ) {

			$content = $content->first();
			unset($content->id);
			unset($content->created_at);
			unset($content->updated_at);
			unset($content->first_name);
			unset($content->last_name);
			unset($content->email);
			unset($content->avatar);

			$data = (array)$content;

			$user = Auth::user();

			$data['title']   = $title;
			$data['url']     = $url;
			$data['abs_url'] = $absUrl;
			$data['status'] = 'draft';


			if ( isset($data['categories']) && count($data['categories']) > 0 ) {
				$tmp = [];
				foreach ( $data['categories'] as $cat ) {
					$tmp[] = $cat['id'];
				}
				$data['categories'] = $tmp;
			}


			$contentFields = ContentField::where( 'content_type_id', '=', $contentType->id )->get();

			if ( $contentType && $contentFields->count() > 0 ) {
				foreach ( $contentFields as $field ) {

					if ( ( $field->type == 'file_upload' || $field->type == 'image_upload') && isset( $data[ $field->name ] ) ) {
						$data[ $field->name ] = $data[ $field->name ]['id'];
					}

					if ( $field->type == 'gallery' && isset( $data[ $field->name ] ) && $data[ $field->name ] ) {
						$tmp = [];
						foreach ( $data[ $field->name ] as $img ) {
							$tmp[] = $img['id'];
						}
						$data[ $field->name ] = join( ',', $tmp );
					}

				}
			}

			if ( isset($data['fb_image']) && $data['fb_image'] ) {
				$data['fb_image'] = $data['fb_image']['id'];
			}

			$request->request->add( $data );

			$newContent = new Content();
			$newContent->user_id = $user->id;
			$newContent->is_home = false;
			$newContent->fill( $data );
			$newContent->save();

			return response()->json( [ 'result' => 'ok', 'content' => $newContent ] );

		}

		return response()->json( [ 'result' => 'ko' ] );
	}

}

