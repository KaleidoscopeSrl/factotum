<?php

use Illuminate\Database\Seeder;

use Factotum\User;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$admin = User::where('email', 'factotum@kaleidoscope.it')->first();

		DB::table('profiles')->where( 'user_id', '=', $admin->id )->delete();

		DB::table('profiles')->insert([
			'first_name' => 'Fac',
			'last_name' => 'Totum',
			'user_id' => $admin->id
		]);
    }
}
