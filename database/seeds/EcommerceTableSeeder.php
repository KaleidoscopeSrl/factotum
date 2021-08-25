<?php

namespace Kaleidoscope\Factotum\Seeds;

use Illuminate\Database\Seeder;

use Kaleidoscope\Factotum\Models\Role;



class EcommerceTableSeeder extends Seeder
{

	private function _setCustomerRole()
	{
		// RUOLO "CUSTOMER"
		$customer = new Role;
		$customer->fill([
			'role'                        => 'customer',
			'editable'                    => 0,
			'backend_access'              => 0,
			'manage_content_types'        => 0,
			'manage_users'                => 0,
			'manage_media'                => 0,
			'manage_settings'             => 0,
			'manage_brands'               => 0,
			'manage_products'             => 0,
			'manage_orders'               => 0,
			'manage_discount_codes'       => 0,
			'manage_product_categories'   => 0,
		]);
		$customer->save();
	}


	private function _changeAdminCapabilities()
	{
		$admin = Role::where('role', 'admin')->first();
		$admin->manage_brands             = 1;
		$admin->manage_products           = 1;
		$admin->manage_orders             = 1;
		$admin->manage_discount_codes     = 1;
		$admin->manage_product_categories = 1;
		$admin->manage_carts              = 1;
		$admin->manage_taxes              = 1;
		$admin->save();
	}


	private function _setGuestUser()
	{
		$customerRole = Role::where('role', 'customer')->first();

		DB::table('users')->where('email', 'guest@kaleidoscope.it')->delete();

		DB::table('users')->insert([
			'email'    => 'guest@kaleidoscope.it',
			'password' => bcrypt(Str::random(8)),
			'role_id'  => $customerRole->id,
			'editable' => false
		]);
	}


    public function run()
    {
		$this->_setCustomerRole();
		$this->_changeAdminCapabilities();
		$this->_setGuestUser();
    }

}
