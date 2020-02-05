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
					$rules['url'] .= '|unique:contents';
				}
			}

		} else {

			$rules['content_type_id'] = 'required';

			$alreadyExist = Content::where('url', '=', $data['url'])->count();

			if ($alreadyExist > 0) {
				$rules['url'] .= '|unique:contents';
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
