<?php

use Illuminate\Database\Seeder;

use Factotum\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$adminRole = Role::where('role', 'admin')->first();

		DB::table('users')->where('email', '=', 'factotum@kaleidoscope.it')->delete();

		DB::table('users')->insert([
			'email'    => 'factotum@kaleidoscope.it',
			'password' => bcrypt('123456'),
			'role_id'  => $adminRole->id,
			'editable' => false
		]);
    }
}
