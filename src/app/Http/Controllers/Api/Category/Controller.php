<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;
use Kaleidoscope\Factotum\Category;

class Controller extends ApiBaseController
{

    protected function validator(Request $request, array $data, $id = null)
    {
        $rules = [
            'label' => 'required',
            'name'  => 'required',
        ];

        /*$lang = $request->session()->get('currentLanguage');

        if ($id) {
            $category = Category::find( $id );
            if ( $category && $category->id != $id ) {
                $rules['name'] .= '|unique:categories,name,NULL,id,content_type_id,' . $category->content_type_id . ',lang,' . $lang;
            }
        } else {
            $rules['name'] .= '|unique:categories,name,NULL,id,content_type_id,' . $data['content_type_id'] . ',lang,' . $lang;
        }*/

        $validator = Validator::make($data, $rules);
        return $validator;
    }

	protected function _save( Request $request, $category )
	{
		$data = $request->all();

		$category->label            = $data['label'];
        $category->name             = $data['name'];
        $category->content_type_id  = $data['content_type_id'];

		if ( isset( $data['parent_id'] ) && $data['parent_id'] != '') {
			$category->parent_id = $data['parent_id'];
		} else {
			$category->parent_id = null;
		}

//        $category->lang = $request->session()->get('currentLanguage');
        $category->lang = 'it';

		$category->save();
		return $category;
	}

}
