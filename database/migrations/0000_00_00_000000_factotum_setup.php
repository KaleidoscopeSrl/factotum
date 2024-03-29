<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FactotumSetup extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create content types tables
		Schema::create('content_types', function (Blueprint $table) {
			$table->id();
			$table->string('label', 64)->nullable(true)->default(null);
			$table->string('content_type', 32)->unique();
			$table->string('old_content_type', 32)->nullable(true);
			$table->boolean('editable')->default(true);
			$table->integer('order_no')->unsigned()->nullable(true);
			$table->string('icon', 64)->nullable(true);
			$table->integer('sitemap_in')->unsigned()->default(0);
			$table->boolean('visible')->default(true)->nullable(true);
			$table->boolean('static_content')->default(false)->nullable(true);
			$table->timestamps();
		});


		// Create content fields table
		Schema::create('content_fields', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('content_type_id')->unsigned();
			$table->foreign('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
			$table->string('name', 50);
			$table->string('old_content_field')->nullable(true);
			$table->string('label', 50);
			$table->string('type', 50);
			$table->integer('order_no')->unsigned()->nullable(true);
			$table->boolean('mandatory')->nullable(true);
			$table->boolean('readonly')->nullable(true);
			$table->string('hint', 255)->nullable(true);
			$table->text('options')->nullable(true);
			$table->integer('max_file_size')->unsigned()->nullable(true);
			$table->integer('min_width_size')->unsigned()->nullable(true);
			$table->integer('min_height_size')->unsigned()->nullable(true);
			$table->string('image_operation', 16)->nullable(true);
			$table->boolean('image_bw')->nullable(true);
			$table->string('allowed_types', 64)->nullable(true);
			$table->text('resizes')->nullable(true);
			$table->bigInteger('linked_content_type_id')->unsigned()->nullable(true)->default(null);
			$table->foreign('linked_content_type_id')->references('id')->on('content_types')->onDelete('cascade');
			$table->text('rules')->nullable(true);
			$table->unique(array('content_type_id', 'name'));
			$table->timestamps();
		});


		// Create roles tables
		Schema::create('roles', function (Blueprint $table) {
			$table->id();
			$table->string('role', 32)->unique();
			$table->boolean('backend_access');
			$table->boolean('manage_content_types');
			$table->boolean('manage_users');
			$table->boolean('manage_media');
			$table->boolean('manage_settings');
			$table->boolean('editable')->default(true);
			$table->timestamps();
		});


		// Create capabilities table
		Schema::create('capabilities', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			$table->bigInteger('content_type_id')->unsigned();
			$table->foreign('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
			$table->boolean('configure');
			$table->boolean('edit');
			$table->boolean('publish');
			$table->unique(array('role_id', 'content_type_id'));
			$table->timestamps();
		});


		// Create users table
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('email')->unique();
			$table->string('password');
			$table->bigInteger('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles');
			$table->boolean('editable')->default(true);
			$table->integer('avatar')->unsigned()->nullable(true);
			$table->timestamp('email_verified_at')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});


		// Create profiles table
		Schema::create('profiles', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('first_name', 64);
			$table->string('last_name', 64);
			$table->timestamps();
		});


		// Create password resets tables
		Schema::create('password_resets', function (Blueprint $table) {
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at')->nullable();
		});


		// Create media table
		Schema::create('media', function (Blueprint $table) {
			$table->id();
			$table->string('filename', 150)->unique();
			$table->string('filename_webp', 150);
			$table->string('thumb', 150)->nullable(true)->default(null);
			$table->string('thumb_webp', 150)->nullable(true)->default(null);
			$table->string('url', 255)->nullable(true);
			$table->string('url_webp', 255)->nullable(true);
			$table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('mime_type', 50);

			$table->integer('width')->nullable(true);
			$table->integer('height')->nullable(true);
			$table->integer('size')->nullable(true);

			$table->text('caption')->nullable(true);
			$table->string('alt_text', 255)->nullable(true);
			$table->text('description')->nullable(true);
			$table->timestamps();
		});


		// Create contents table
		Schema::create('contents', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('content_type_id')->unsigned();
			$table->foreign('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
			$table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->bigInteger('parent_id')->unsigned()->nullable(true);
			$table->foreign('parent_id')->references('id')->on('contents')->onDelete('cascade');
			$table->string('status', 25);
			$table->string('title', 255);
			$table->text('content')->nullable(true);
			$table->string('url', 191);
			$table->string('abs_url', 191)->nullable(true)->unique();
			$table->string('lang', 5);
			$table->boolean('show_in_menu');
			$table->boolean('is_home')->default(false)->nullable(true);
			$table->integer('order_no')->nullable(true);
			$table->string('seo_title', 70)->nullable(true);
			$table->text('seo_description')->nullable(true);
			$table->string('seo_canonical_url', 255)->nullable(true);
			$table->string('seo_robots_indexing', 10)->default('index')->nullable(true);
			$table->string('seo_robots_following', 10)->default('follow')->nullable(true);
			$table->string('seo_focus_key', 255)->nullable(true);
			$table->string('fb_title', 255)->nullable(true);
			$table->string('fb_description', 255)->nullable(true);
			$table->integer('fb_image')->nullable(true);
			$table->timestamps();
		});


		// Create categories tables
		Schema::create('categories', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('content_type_id')->unsigned();
			$table->foreign('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
			$table->bigInteger('parent_id')->unsigned()->nullable(true);
			$table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
			$table->string('name', 50);
			$table->string('label', 255);
			$table->string('abs_url', 255 )->nullable();
			$table->text('description')->nullable();
			$table->string('lang', 5);
			$table->integer('order_no')->nullable(true);

			$table->string('seo_title', 70)->nullable(true);
			$table->text('seo_description')->nullable(true);
			$table->string('seo_canonical_url', 255)->nullable(true);
			$table->string('seo_robots_indexing', 10)->default('index')->nullable(true);
			$table->string('seo_robots_following', 10)->default('follow')->nullable(true);
			$table->string('seo_focus_key', 255)->nullable(true);

			$table->string('fb_title', 255)->nullable(true);
			$table->string('fb_description', 255)->nullable(true);
			$table->bigInteger('fb_image')->unsigned()->nullable(true);
			$table->foreign('fb_image')->references('id')->on('media');

			$table->timestamps();
		});


		// Create content categories tables
		Schema::create('category_content', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->bigInteger('content_id')->unsigned();
			$table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
			$table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::disableForeignKeyConstraints();

		Schema::drop('category_content');
		Schema::drop('categories');
		Schema::drop('contents');

		Schema::drop('media');
		Schema::drop('profiles');

		Schema::drop('content_fields');

		Schema::drop('capabilities');

		Schema::drop('content_types');

		Schema::drop('users');
		Schema::drop('roles');
		Schema::drop('password_resets');

		Schema::enableForeignKeyConstraints();
	}

}
