<?php

namespace Kaleidoscope\Factotum\Models;

use Kaleidoscope\Factotum\Database\Factories\RoleFactory;


class Role extends BaseModel
{

	protected static function newFactory()
	{
		return RoleFactory::new();
	}


	protected $fillable = [
		'role',
		'backend_access',
		'manage_content_types',
		'manage_users',
		'manage_media',
		'manage_settings',
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
