<?php

namespace Kaleidoscope\Factotum\Http\Requests;


use Illuminate\Support\Carbon;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;

class StoreContent extends CustomFormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'title'   => 'required|max:255',
			'url'     => 'required|max:191',
			'status'  => 'required',
		];

		$data = $this->all();

		$id = request()->route('id');

		if ($id) {
			$content = Content::find($id);
			if ( $data['url'] != $content->url ) {
				$alreadyExist = Content::where('url', '=', $data['url'])
					->where( 'content_type_id', '=', $content->content_type_id )
					->count();
				if ($alreadyExist > 0) {
					$rules['url'] .= '|unique:contents';
				}
			}

			$contentFields = ContentField::where( 'content_type_id', '=', $content->content_type_id )->get();

		} else {
			$rules['content_type_id'] = 'required';

			$alreadyExist = Content::where('url', '=', $data['url'])
				->where( 'content_type_id', '=', $data['content_type_id'] )
				->count();
			if ($alreadyExist > 0) {
				$rules['url'] .= '|unique:contents';
			}

			$contentFields = ContentField::where( 'content_type_id', '=', $data['content_type_id'] )->get();
		}


		// Additional Fields
		if ( $contentFields->count() > 0 ) {
			foreach ( $contentFields as $field ) {
				$tmp = array();

				if ( $field->mandatory ) {
					if (count($data) > 0 && ( $field->type == 'file_upload' || $field->type == 'image_upload'  || $field->type == 'gallery' )) {
						if ( !isset($data[ $field->name . '_hidden' ]) ||
							(isset($data[ $field->name . '_hidden' ]) && $data[ $field->name . '_hidden' ] == '' ) ) {
							$tmp[] = 'required';
						}
					} else {
						$tmp[] = 'required';
					}
				}

//				if ( $request->input( $field->name ) &&
//					( $field->type == 'file_upload' || $field->type == 'image_upload' || $field->type == 'gallery' )
//				) {
//					$tmp[] = 'max:' . $field->max_file_size*1000;
//					if ($field->allowed_types != '*') {
//						$field->allowed_types = str_replace('jpg', 'jpeg', $field->allowed_types);
//						$field->allowed_types = str_replace('.', '', $field->allowed_types);
//						$tmp[] = 'mimes:' . $field->allowed_types;
//					}
//				}

//				if ( $request->input( $field->name ) &&
//					( $field->type == 'image_upload' || $field->type == 'gallery' )
//				) {
//					$tmp[] = 'dimensions:min_width=' . $field->min_width_size . ',min_height=' . $field->min_height_size;
//				}


//				if ( $field->type == 'gallery' && $request->file( $field->name ) ) {
//					$nbr = count( $request->file( $field->name ) ) - 1;
//					foreach(range(0, $nbr) as $index) {
//						$rules[ $field->name .  '.' . $index ] = join( '|', $tmp );
//					}
//				} else {
//					$rules[ $field->name ] = join( '|', $tmp );
//				}

			}
		}

		$this->merge($data);

		return $rules;
	}


	protected function getValidatorInstance()
	{
		$data = $this->all();

		$data['url'] = str_slug($data['url'], "-");

		$data['lang'] = request()->session()->get('currentLanguage');

		// Aggiungo al path la lingua solo se è diversa da quella di default
		// TODO: rendere personalizzabile questa scelta dalle impostazioni
		$data['abs_url'] = url('') . '/'
			. ( $data['lang'] != config('factotum.main_site_language') ? $data['lang'] . '/' : '' )
			. $data['url'];

		$contentType = ContentType::find($data['content_type_id']);
		if ( $contentType->content_type !== 'page' ) {
			$data['link']         = '';
			$data['link_title']   = '';
			$data['link_open_in'] = null;
		}

		if ( $data['created_at'] ) {
			$data['created_at'] = Carbon::createFromTimeString($data['created_at']);
		}

		if ( !isset($data['show_in_menu']) ) {
			$data['show_in_menu'] = 0;
		}

		$this->merge($data);

		return parent::getValidatorInstance();
	}

}
