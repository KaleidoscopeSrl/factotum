<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\CategoryContent;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Media;
use Kaleidoscope\Factotum\Profile;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\User;


class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$path = base_path('.env');
		if ( file_exists($path) && !env('FACTOTUM_INSTALLED') ) {
			file_put_contents ( $path , 'FACTOTUM_INSTALLED=true', FILE_APPEND );
		}

		$this->setFKCheckOff();

		Capability::truncate();
		Category::truncate();
		Content::truncate();
		CategoryContent::truncate();
		ContentField::truncate();
		ContentType::truncate();
		Media::truncate();
		Profile::truncate();
		Role::truncate();
		User::truncate();

		if (Schema::hasTable('page')) {
			Schema::drop( 'page' );
		}

		$this->setFKCheckOn();

		$this->call(RolesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(ProfilesTableSeeder::class);
		$this->call(PageTableSeeder::class);
	}

	private function setFKCheckOff() {
		switch(DB::getDriverName()) {
			case 'mysql':
				DB::statement('SET FOREIGN_KEY_CHECKS=0');
			break;
			case 'sqlite':
				DB::statement('PRAGMA foreign_keys = OFF');
			break;
		}
	}

	private function setFKCheckOn() {
		switch(DB::getDriverName()) {
			case 'mysql':
				DB::statement('SET FOREIGN_KEY_CHECKS=1');
			break;
			case 'sqlite':
				DB::statement('PRAGMA foreign_keys = ON');
			break;
		}
	}
}
