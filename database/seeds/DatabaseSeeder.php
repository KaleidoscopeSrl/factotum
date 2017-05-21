<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentCategory;
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

		DB::statement('SET foreign_key_checks=0');

		Capability::truncate();
		Category::truncate();
		Content::truncate();
		ContentCategory::truncate();
		ContentField::truncate();
		ContentType::truncate();
		Media::truncate();
		Profile::truncate();
		Role::truncate();
		User::truncate();

		if (Schema::hasTable('page')) {
			Schema::drop( 'page' );
		}

		DB::statement('SET foreign_key_checks=1');

		$this->call(RolesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(ProfilesTableSeeder::class);
		$this->call(PageTableSeeder::class);
	}
}
