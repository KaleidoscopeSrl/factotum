<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Kaleidoscope\Factotum\Models\ProductCategory;


class FactotumGenerateProductAttributesIndex extends Command
{

	protected $signature = 'factotum:generate-product-attributes-index';

	protected $description = 'Generate Product Attributes Index';


	public function handle()
	{
		$this->info('Starting Product Attributes Index generation');

		$finalJSON         = [];
		$productCategories = ProductCategory::whereNull('parent_id')->get();

		if ( $productCategories->count() > 0 ) {

			foreach ( $productCategories as $productCategory ) {
				$childCategories = $productCategory->getFlatChildsArray();
				array_unshift($childCategories, $productCategory );

				if ( count($childCategories) > 0 ) {

					foreach ( $childCategories as $category ) {

						$query = DB::table('products')
							        ->join('product_product_category', 'product_product_category.product_id', 'products.id')
							        ->whereNull('products.deleted_at')
						        	->where('product_product_category.product_category_id', $category->id);

						$products = $query->get();

						if ( $products->count() > 0 ) {

							$tmpProductIds = [];
							foreach ( $products as $product ) {
								$tmpProductIds[] = $product->id;
							}

							$selects = [
								'product_attributes.label as main_label',
								'product_attributes.name as main_name',
								'product_attribute_values.product_attribute_id',
								'product_attribute_values.id as product_attribute_value_id',
								'product_attribute_values.name',
								'product_attribute_values.label'
							];

							$paQuery = DB::table('product_product_attribute_value')
										->selectRaw( join(',' , $selects) )
										->join('product_attribute_values', 'product_product_attribute_value.product_attribute_value_id', '=', 'product_attribute_values.id')
										->join('product_attributes', 'product_attribute_values.product_attribute_id', '=', 'product_attributes.id')
										->whereIn('product_product_attribute_value.product_id', $tmpProductIds);

							$productAttributes = $paQuery->get();

							if ( $productAttributes->count() > 0 ) {

								$category = $category->toArray();
								$category['product_attributes'] = [];

								$finalItem = [
									'category' => $category,
								];

								foreach ( $productAttributes as $pa ) {
									if ( !isset($finalItem['category']['product_attributes'][$pa->product_attribute_id]) ) {
										$finalItem['category']['product_attributes'][$pa->product_attribute_id] = [
											'id'         => $pa->product_attribute_id,
											'main_name'  => $pa->main_name,
											'main_label' => $pa->main_label,
											'values'     => []
										];
									}

									if ( !isset($finalItem['category']['product_attributes'][$pa->product_attribute_id]['values'][$pa->product_attribute_value_id]) ) {
										$finalItem['category']['product_attributes'][$pa->product_attribute_id]['values'][$pa->product_attribute_value_id] = [
											'id'    => $pa->product_attribute_value_id,
											'name'  => $pa->name,
											'label' => $pa->label,
										];
									}
								}

								$finalJSON[]  = $finalItem;

							}

						}

					}

				}

			}

		}


		$folderName = storage_path( 'app' );
		$fileName   = 'product-attributes.json';

		if ( !file_exists( $folderName ) ) {
			File::makeDirectory( $folderName );
		}

		$finalJSON = json_encode( $finalJSON );

		$handle = fopen( $folderName . '/' . $fileName, 'w' );
		fwrite( $handle, $finalJSON);
		fclose( $handle );

		$this->info('Finish Product Attributes Index generation');
	}

}