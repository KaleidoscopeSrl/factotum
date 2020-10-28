<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class FactotumPimSetup extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('pim_mapping', function (Blueprint $table) {
			$table->id();

			$table->bigInteger('content_id')->unsigned()->nullable();
			$table->foreign('content_id')->references('id')->on('contents');

			$table->bigInteger('content_type_id')->unsigned()->nullable();
			$table->foreign('content_type_id')->references('id')->on('content_types');

			$table->bigInteger('pim_id')->unsigned()->nullable();

			$table->string('lang', 5)->nullable();

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

		Schema::drop('pim_mapping');

		Schema::enableForeignKeyConstraints();
	}

}
