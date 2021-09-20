<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;


class ProductProductAttributeValue extends Model
{

	protected $table = 'product_product_attribute_value';

	protected $fillable = [
		'product_id',
		'product_attribute_value_id',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];


	public function product_attribute_value() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\ProductAttributeValue', 'id', 'product_attribute_value_id');
	}


	public function product() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Product', 'id', 'product_id');
	}

}
