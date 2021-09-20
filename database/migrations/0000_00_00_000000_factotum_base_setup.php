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
		// Create roles tables
		Schema::create('roles', function (Blueprint $table) {
			$table->id();
			$table->string('role', 32)->unique();
			$table->boolean('backend_access');
			$table->boolean('manage_content_types');
			$table->boolean('manage_users');
			$table->boolean('manage_media');
			$table->boolean('manage_settings');

			$table->boolean('manage_brands')->nullable()->default(null);
			$table->boolean('manage_products')->nullable()->default(null);
			$table->boolean('manage_orders')->nullable()->default(null);
			$table->boolean('manage_discount_codes')->nullable()->default(null);
			$table->boolean('manage_product_categories')->nullable()->default(null);
			$table->boolean('manage_carts')->nullable()->default(null);
			$table->boolean('manage_taxes')->nullable()->default(null);
			$table->boolean('manage_newsletters')->nullable()->default(null);

			$table->boolean('editable')->default(true);
			$table->timestamps();
		});


		// Create capabilities table
		Schema::create('capabilities', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			$table->boolean('configure');
			$table->boolean('edit');
			$table->boolean('publish');
			$table->unique(array('role_id', 'content_type_id'));
			$table->timestamps();
		});


		// Create users table
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('email', 128)->unique();
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
			$table->string('first_name', 128);
			$table->string('last_name', 128);
			$table->string('phone', 64)->nullable();
			$table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->boolean('privacy')->nullable()->default(0);
			$table->boolean('newsletter')->nullable()->default(0);
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

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::disableForeignKeyConstraints();

		Schema::drop('media');
		Schema::drop('password_resets');
		Schema::drop('profiles');
		Schema::drop('capabilities');
		Schema::drop('users');
		Schema::drop('roles');


		Schema::enableForeignKeyConstraints();
	}

}
