<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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

		if ( $id ) {

			$content = Content::find($id);

			if ( $data['url'] != $content->url ) {

				$alreadyExist = Content::where('url', '=', $data['url'])->count();

				if ( $alreadyExist > 0 ) {
					$rules['url'] .= '|unique:contents,id,' . $id;
				}
			}


		} else {

			$rules['content_type_id'] = 'required';

			$alreadyExist = Content::where('url', '=', $data['url'])->count();

			if ($alreadyExist > 0) {
				$rules['url'] .= '|unique:contents';
			}

		}


		if ( isset($data['content_type_id']) ) {
			$contentFields = ContentField::where( 'content_type_id', '=', $data['content_type_id'] )->get();

			if ( $contentFields->count() > 0 ) {
				foreach ( $contentFields as $cf ) {

					if ( $cf->mandatory ) {
						$rules[ $cf->name ] = 'required';
					}

					if ( $cf->type == 'email' ) {
						$rules[ $cf->name ] .= '|email';
					}

					if ( $cf->type == 'url' ) {
						$rules[ $cf->name ] .= '|url';
					}

					if ( $cf->type == 'number' ) {
						$rules[ $cf->name ] .= '|numeric';
					}

					if ( $cf->type == 'date' ) {
						if ( isset($rules[ $cf->name ]) ) {
							$rules[ $cf->name ] .= '|date_format:Y-m-d';
						} else {
							$rules[ $cf->name ] = 'date_format:Y-m-d';
						}
					}

					if ( $cf->type == 'time' ) {
						if ( isset($rules[ $cf->name ]) ) {
							$rules[ $cf->name ] .= '|date_format:H:i';
						} else {
							$rules[ $cf->name ] = 'date_format:H:i';
						}
					}

					if ( $cf->type == 'datetime' ) {
						if ( isset($rules[ $cf->name ]) ) {
							$rules[ $cf->name ] .= '|date_format:Y-m-d H:i:s';
						} else {
							$rules[ $cf->name ] = 'date_format:Y-m-d H:i:s';
						}
					}

				}
			}
		}


		$this->merge($data);

		return $rules;
	}


	protected function getValidatorInstance()
	{
		$data = $this->all();

		$data['url'] = ( $data['url'] != '/' ? Str::slug( $data['url'], '-') : '/' );

		// Aggiungo al path la lingua solo se è diversa da quella di default
		// TODO: rendere personalizzabile questa scelta dalle impostazioni
		$data['abs_url'] = url('') . '/'
			. ( $data['lang'] != config('factotum.main_site_language') ? $data['lang'] . '/' : '' )
			. ( $data['url'] != '/' ? $data['url'] : '' );

		if ( isset($data['created_at']) ) {
			$data['created_at'] = Carbon::createFromTimeString($data['created_at']);
		}

		if ( !isset($data['show_in_menu']) ) {
			$data['show_in_menu'] = 0;
		}

		$this->merge($data);

		return parent::getValidatorInstance();
	}

}