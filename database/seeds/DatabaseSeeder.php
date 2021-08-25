<?php

namespace Kaleidoscope\Factotum\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Kaleidoscope\Factotum\Models\Capability;
use Kaleidoscope\Factotum\Models\Category;
use Kaleidoscope\Factotum\Models\Content;
use Kaleidoscope\Factotum\Models\CategoryContent;
use Kaleidoscope\Factotum\Models\ContentField;
use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Models\Media;
use Kaleidoscope\Factotum\Models\Profile;
use Kaleidoscope\Factotum\Models\Role;
use Kaleidoscope\Factotum\Models\User;


class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
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
