<?php

namespace Kaleidoscope\Factotum;

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
	];

	public function __construct()
	{
		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
			$this->fillable[] = 'manage_brands';
			$this->fillable[] = 'manage_products';
			$this->fillable[] = 'manage_orders';
			$this->fillable[] = 'manage_discount_codes';
			$this->fillable[] = 'manage_product_categories';
			$this->fillable[] = 'manage_carts';
			$this->fillable[] = 'manage_taxes';
		}
	}


	protected $hidden = [
		'editable',
		'created_at', 'updated_at', 'deleted_at'
	];


	public function user() {
		return $this->belongsTo('Kaleidoscope\Factotum\User');
	}


	public function capabilities() {
		return $this->hasMany('Kaleidoscope\Factotum\Capability');
	}

}
