<?php

namespace Kaleidoscope\Factotum\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Models\Role;


class UsersTableSeeder extends Seeder
{

    public function run()
    {
		$adminRole = Role::where('role', 'admin')->first();

		DB::table('users')->where('email', 'factotum@kaleidoscope.it')->delete();

		DB::table('users')->insert([
			'email'    => 'factotum@kaleidoscope.it',
			'password' => bcrypt('12345678'),
			'role_id'  => $adminRole->id,
			'editable' => false
		]);
    }

}
