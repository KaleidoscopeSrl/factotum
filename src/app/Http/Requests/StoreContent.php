<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;

class StoreContent extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [
			'title'   => 'required|max:255',
			'status'  => 'required',
		];

		$data = $this->all();

		$urlRules = [
			'required',
			'max:191'
		];

		$id = request()->route('id');

		if ( $id ) {

			$content = Content::find($id);

			if ( $data['url'] != $content->url ) {

				$alreadyExist = Content::where('url', '=', $data['url'])->count();

				if ( $alreadyExist > 0 ) {
					$urlRules[] = Rule::unique('contents')->ignore($id);
				}
			}


		} else {

			$rules['content_type_id'] = 'required';

			$alreadyExist = Content::where('url', '=', $data['url'])->count();

			if ( $alreadyExist > 0 ) {
				$urlRules[] = Rule::unique('contents');
			}

		}

		$rules['url'] = $urlRules;

		if ( isset($data['content_type_id']) ) {
			$contentFields = ContentField::where( 'content_type_id', '=', $data['content_type_id'] )->get();

			if ( $contentFields->count() > 0 ) {
				foreach ( $contentFields as $cf ) {

					$checkMandatory = true;

					// Se il campo ha regole di visualizzazione controllo che sia visibile per la rule require
					if ( $cf->rules ) {
						$checkMandatory = false;

						foreach ( $cf->rules as $cfRuleSet ) {
							$checkSet = true;

							foreach ( $cfRuleSet as $cfRule ) {

								switch ( $cfRule['operator'] ) {
									case '=' :
										$checkRule = $data[ $cfRule['contentField'] ] === $cfRule['value'];
										break;
									case '<>' :
										$checkRule = $data[ $cfRule['contentField'] ] !== $cfRule['value'];
										break;
									case '<' :
										$checkRule = $cfRule['value'] < $data[ $cfRule['contentField'] ];
										break;
									case '>' :
										$checkRule = $cfRule['value'] > $data[ $cfRule['contentField'] ];
										break;
									default:
										$checkRule = false;
								}

								$checkSet = $checkSet && $checkRule;

							}

							$checkMandatory = $checkMandatory || $checkSet;
						}
					}

					$rule = [];

					if ( $checkMandatory && $cf->mandatory ) {
						$rule[] = 'required';
					}

					if ( $cf->type == 'email' ) {
						$rule[] = 'email';
					}

					if ( $cf->type == 'url' ) {
						$rule[] = 'url';
					}

					if ( $cf->type == 'number' ) {
						$rule[] = 'numeric';
					}

					if ( $cf->type == 'date' ) {
						$rule[] = 'date_format:Y-m-d';
					}

					if ( $cf->type == 'time' ) {
						$rule[] = 'date_format:H:i';
					}

					if ( $cf->type == 'datetime' ) {
						$rule[] = 'date_format:Y-m-d H:i:s';
					}

					$rules[ $cf->name ] = join('|', $rule);

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
