<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class FactotumEcommerceSetup extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Brands table
		Schema::create('brands', function (Blueprint $table) {
			$table->id();
			$table->string('code', 8);
			$table->string('name', 50);
			$table->bigInteger('logo')->unsigned()->nullable();
			$table->foreign('logo')->references('id')->on('media');
			$table->integer('order_no')->nullable(true);
			$table->timestamps();
			$table->softDeletes();
		});


		// Product Categories table
		Schema::create('product_categories', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('parent_id')->unsigned()->nullable(true);
			$table->string('name', 50);
			$table->string('label', 255);
			$table->text('description')->nullable();
			$table->string('lang', 5);

			$table->bigInteger('image')->nullable(true);

			$table->bigInteger('icon')->nullable(true);
			$table->integer('order_no')->nullable(true);

			$table->timestamps();
			$table->softDeletes();
		});

		Schema::table('product_categories', function (Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('product_categories')->onUpdate('cascade')->onDelete('cascade');
		});


		// Create products table
		Schema::create('products', function (Blueprint $table) {
			$table->id();

			$table->string('code', 16);
			$table->boolean('active')->nullable();
			$table->string('url', 191);
			$table->string('abs_url', 191)->nullable(true)->unique();
			$table->string('lang', 5);
			$table->string('name', 128);
			$table->text('description')->nullable();
			$table->string('barcode', 64)->nullable();
			$table->string('gallery')->nullable();
			$table->decimal('basic_price', 10, 2);
			$table->decimal('discount_price', 10, 2);
			$table->text('attributes')->nullable()->default(null);

			$table->bigInteger('image')->unsigned()->nullable();
			$table->foreign('image')->references('id')->on('media');

			$table->bigInteger('brand_id')->unsigned()->nullable();
			$table->foreign('brand_id')->references('id')->on('brands');

			$table->bigInteger('product_category_id')->unsigned()->nullable();
			$table->foreign('product_category_id')->references('id')->on('product_categories');

			$table->integer('order_no')->nullable(true);
			$table->string('seo_title', 60)->nullable(true);
			$table->text('seo_description')->nullable(true);
			$table->string('seo_canonical_url', 255)->nullable(true);
			$table->string('seo_robots_indexing', 10)->default('index')->nullable(true);
			$table->string('seo_robots_following', 10)->default('follow')->nullable(true);
			$table->string('seo_focus_key', 255)->nullable(true);
			$table->string('fb_title', 255)->nullable(true);
			$table->string('fb_description', 255)->nullable(true);
			$table->bigInteger('fb_image')->nullable(true);

			$table->timestamps();
			$table->softDeletes();
		});


		// Create carts tables
		Schema::create('carts', function (Blueprint $table) {
			$table->id();

			$table->bigInteger('customer_id')->unsigned()->nullable();
			$table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');

			$table->timestamp('expires_at')->nullable();

			$table->decimal( 'total', 10, 2)->nullable();
			$table->string('status', 16);

			$table->timestamps();
			$table->softDeletes();
		});


		// Create cart products tables
		Schema::create('cart_products', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('cart_id')->unsigned();
			$table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
			$table->bigInteger('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

			$table->integer('quantity')->default(0);
			$table->decimal( 'product_price', 10, 2)->nullable();
			$table->text('tax_data')->nullable();
			$table->decimal( 'tax_cost', 10, 2)->nullable();

			$table->timestamps();
		});


		// Added new fields for shipping/invoice address
		Schema::table('profiles', function (Blueprint $table) {
			$table->string('phone', 64)->nullable()->after('first_name');
			$table->string('delivery_address', 128)->nullable()->after('phone');
			$table->string('delivery_city', 64)->nullable()->after('delivery_address');
			$table->string('delivery_zip', 7)->nullable()->after('delivery_city');
			$table->string('delivery_province', 16)->nullable()->after('delivery_zip');
			$table->string('delivery_nation', 64)->nullable()->after('delivery_province');

			$table->string('invoice_address', 128)->nullable()->after('delivery_nation');
			$table->string('invoice_city', 64)->nullable()->after('invoice_address');
			$table->string('invoice_zip', 7)->nullable()->after('invoice_city');
			$table->string('invoice_province', 16)->nullable()->after('invoice_zip');
			$table->string('invoice_nation', 64)->nullable()->after('invoice_province');

			$table->boolean('privacy')->nullable()->after('invoice_nation')->default(0);
			$table->boolean('newsletter')->nullable()->after('privacy')->default(0);
			$table->boolean('partner_offers')->nullable()->after('newsletter')->default(0);
			$table->boolean('terms_conditions')->nullable()->after('partner_offers')->default(0);
		});

		Schema::table('roles', function (Blueprint $table) {
			$table->boolean('manage_brands')->nullable()->default(null)->after('manage_settings');
			$table->boolean('manage_products')->nullable()->default(null)->after('manage_brands');
			$table->boolean('manage_orders')->nullable()->default(null)->after('manage_products');
			$table->boolean('manage_discount_codes')->nullable()->default(null)->after('manage_orders');
			$table->boolean('manage_product_categories')->nullable()->default(null)->after('manage_discount_codes');
			$table->boolean('manage_carts')->nullable()->default(null)->after('manage_product_categories');
			$table->boolean('manage_taxes')->nullable()->default(null)->after('manage_carts');
		});


		// Create discount codes table
		Schema::create('discount_codes', function (Blueprint $table) {
			$table->id();

			$table->string('code', 32);
			$table->decimal('discount', 10, 2 );
			$table->integer('amount');
			$table->string('type', 16);

			$table->bigInteger('customer_id')->unsigned()->nullable();
			$table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');

			$table->timestamps();
			$table->softDeletes();
		});


		// Create product discount codes
		Schema::create('product_discount_codes', function (Blueprint $table) {
			$table->id();

			$table->bigInteger('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

			$table->bigInteger('discount_code_id')->unsigned();
			$table->foreign('discount_code_id')->references('id')->on('discount_codes')->onDelete('cascade');

			$table->timestamps();
			$table->softDeletes();
		});


		// Create taxes
		Schema::create('taxes', function (Blueprint $table) {
			$table->id();

			$table->string('name', 128);
			$table->float('amount');
			$table->string('description', 255)->nullable();

			$table->timestamps();
			$table->softDeletes();
		});


		// Create product taxes
		Schema::create('product_taxes', function (Blueprint $table) {
			$table->id();

			$table->bigInteger('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

			$table->bigInteger('tax_id')->unsigned();
			$table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');

			$table->timestamps();
			$table->softDeletes();
		});


		// Create orders tables
		Schema::create('orders', function (Blueprint $table) {
			$table->id();

			$table->bigInteger('customer_id')->unsigned();
			$table->bigInteger('cart_id')->unsigned();
			$table->bigInteger('discount_code_id')->unsigned()->nullable();

			$table->string('status', 16);
			$table->decimal('total_net', 10, 2 );
			$table->decimal('total_tax', 10, 2 );

			$table->string('phone', 64)->nullable();
			$table->string('delivery_address', 128)->nullable();
			$table->string('delivery_city', 64)->nullable();
			$table->string('delivery_zip', 7)->nullable();
			$table->string('delivery_province', 16)->nullable();
			$table->string('delivery_nation', 64)->nullable();

			$table->string('invoice_address', 128)->nullable();
			$table->string('invoice_city', 64)->nullable();
			$table->string('invoice_zip', 7)->nullable();
			$table->string('invoice_province', 16)->nullable();
			$table->string('invoice_nation', 64)->nullable();

			$table->text('notes')->nullable();
			$table->string('payment_type', 64)->nullable();
			$table->string('transaction_id', 128)->nullable();
			$table->text('customer_user_agent')->nullable();

			$table->timestamps();
			$table->softDeletes();
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
			DB::statement('ALTER TABLE orders ADD CONSTRAINT orders_discount_code_id_foreign FOREIGN KEY (discount_code_id) REFERENCES discount_codes(id) ON DELETE CASCADE');
		});


		// Create order products tables
		Schema::create('order_product', function (Blueprint $table) {
			$table->id();

			$table->bigInteger('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
			$table->bigInteger('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->integer('quantity')->default(0);
			$table->text('tax_data')->nullable();
			$table->decimal( 'tax_cost', 10, 2)->nullable();

			$table->timestamps();
			$table->softDeletes();
		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_discount_codes');
		Schema::drop('discount_codes');
		Schema::drop('product_taxes');
		Schema::drop('taxes');
		Schema::drop('order_products');
		Schema::drop('orders');
		Schema::drop('cart_products');
		Schema::drop('carts');
		Schema::drop('products');
		Schema::drop('product_categories');
		Schema::drop('brands');
	}

}