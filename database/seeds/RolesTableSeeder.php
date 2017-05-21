<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('roles')->where('role', '=', 'admin')->delete();
		DB::table('roles')->where('role', '=', 'subscriber')->delete();

		DB::table('roles')->insert([
			'role'                      => 'admin',
			'backend_access'            => 1,
			'manage_content_types'      => 1,
			'manage_users'              => 1,
			'manage_categories'         => 1,
			'manage_media'              => 1,
			'manage_settings'           => 1,
			'editable'                  => 0
		]);

		DB::table('roles')->insert([
			'role'                      => 'subscriber',
			'backend_access'            => 0,
			'manage_content_types'      => 0,
			'manage_users'              => 0,
			'manage_categories'         => 0,
			'manage_media'              => 1,
			'manage_settings'           => 0,
		]);
    }
}