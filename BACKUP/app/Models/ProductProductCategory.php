<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductProductCategory extends Model
{

	protected $table = 'product_product_category';


	protected $fillable = [
		'product_category_id',
		'product_id',
	];


	protected $hidden = [
		'deleted_at'
	];


	public function product_category() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\ProductCategory', 'id', 'product_category_id');
	}


	public function product() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Product', 'id', 'product_id');
	}

}
