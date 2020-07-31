<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class FactotumNewsletterSetup extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Campaign templates table
		Schema::create('campaign_templates', function (Blueprint $table) {
			$table->id();

			$table->string('title', 64);
			$table->string('subject', 255);

			$table->text('content')->nullable();
			$table->text('design')->nullable();

			$table->timestamps();
			$table->softDeletes();
		});


		// Campaign Attachmentd table
		Schema::create('campaign_attachments', function (Blueprint $table) {
			$table->id();

			$table->bigInteger( 'campaign_template_id')->unsigned();
			$table->foreign('campaign_template_id')->references('id')->on('campaign_templates');

			$table->bigInteger('attachment_id')->unsigned()->nullable();
			$table->foreign('attachment_id')->references('id')->on('media');

			$table->timestamps();
		});


		// Campaign lists table
		Schema::create('campaign_lists', function (Blueprint $table) {
			$table->id();

			$table->string('title', 255);
			$table->text('filter')->nullable();

			$table->timestamps();
			$table->softDeletes();
		});


		// Campaign lists user table
		Schema::create('campaign_list_user', function (Blueprint $table) {
			$table->id();

			$table->bigInteger( 'campaign_list_id')->unsigned();
			$table->foreign('campaign_list_id')->references('id')->on('campaign_lists');

			$table->bigInteger( 'user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->timestamps();
			$table->softDeletes();
		});


		// Campaigns table
		Schema::create('campaigns', function (Blueprint $table) {
			$table->id();

			$table->bigInteger( 'campaign_template_id')->unsigned();
			$table->foreign('campaign_template_id')->references('id')->on('campaign_templates');

			$table->bigInteger( 'campaign_list_id')->unsigned();
			$table->foreign('campaign_list_id')->references('id')->on('campaign_lists');

			$table->string('title', 255);
			$table->timestamp('sent_at')->nullable();

			$table->timestamps();
			$table->softDeletes();
		});


		Schema::create('campaign_emails', function (Blueprint $table) {
			$table->id();

			$table->bigInteger( 'user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->bigInteger( 'campaign_id')->unsigned();
			$table->foreign('campaign_id')->references('id')->on('campaigns');

			$table->string( 'status', 32)->nullable();

			$table->timestamps();
			$table->softDeletes();
		});


		Schema::table('roles', function (Blueprint $table) {
			$table->boolean('manage_newsletters')->nullable()->default(null)->after('manage_settings');
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

		Schema::drop('campaign_emails');
		Schema::drop('campaigns');
		Schema::drop('campaign_attachments');
		Schema::drop('campaign_templates');

		Schema::enableForeignKeyConstraints();
	}

}
