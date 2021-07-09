<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;


class ProductAttributeValue extends Model
{

	protected $fillable = [
		'product_attribute_id',
		'name',
		'label',
	];

	protected $hidden = [
		'created_at',
		'updated_at',
	];

	public function product_attribute()
	{
		return $this->belongsTo('Kaleidoscope\Factotum\Models\ProductAttribute', 'product_attribute_id', 'id');
	}

	// TODO: aggiungere quantità come proprietà in append (totale dei prodotti su cui è applicata)

}
