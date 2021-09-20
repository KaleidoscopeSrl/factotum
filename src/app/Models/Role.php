<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	protected $fillable = [
		'role',
		'backend_access',
		'manage_content_types',
		'manage_users',
		'manage_media',
		'manage_settings',
		'manage_categories',
		'manage_brands',
		'manage_products',
		'manage_orders',
		'manage_discount_codes',
		'manage_product_categories',
		'manage_carts',
		'manage_taxes',
		'manage_newsletters',
	];


	protected $hidden = [
		'editable',
	];



	public function user() {
		return $this->belongsTo('Kaleidoscope\Factotum\Models\User');
	}

	public function capabilities() {
		return $this->hasMany('Kaleidoscope\Factotum\Models\Capability');
	}

}
