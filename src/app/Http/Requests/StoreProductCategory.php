<?php

namespace Kaleidoscope\Factotum\Http\Requests;


use Kaleidoscope\Factotum\ProductCategory;

class StoreProductCategory extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [];
		$data  = $this->all();

		$productCategoriesViaPim = config('factotum.product_categories_via_pim');

		// TODO: categoria unique ma solo su categorie non "deleted_at"
		if ( !$productCategoriesViaPim ) {

			$rules = [
				'label' => 'required|max:255',
				'name'  => 'required|max:50',
			];

			$productCategory = ProductCategory::where( 'parent_id', $data['parent_id'] )
											->where( 'name', $data['name'] )
											->first();

			if ( $productCategory ) {
				$rules['name'] .= '|unique:product_categories,name,parent_id';
			}

			if ( $productCategory->name == $data['name'] ) {
				unset( $rules['name'] );
			}

			$id = request()->route('id');

			if ( $id ) {
				$productCategory = ProductCategory::where( 'parent_id', $data['parent_id'] )
													->where( 'name', $data['name'] )
													->where( 'id', '!=', $id )
													->first();

				if ( $productCategory ) {
					$rules['name'] .= '|unique:product_categories,name,parent_id,' . $id;
				}
			}

		}

		$this->merge($data);

		return $rules;
	}


}
