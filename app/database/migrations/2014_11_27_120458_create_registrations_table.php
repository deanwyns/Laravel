<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registrations', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_paid')->default(false);
			$table->integer('child_id')->unsigned();
			$table->integer('vacation_id')->unsigned();
			$table->string('facturation_first_name');
			$table->string('facturation_last_name');
			$talbe->integer('facturation_address_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('registrations');
	}
}
