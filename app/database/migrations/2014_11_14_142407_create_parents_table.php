<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_parents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name_mother')->default('');
			$table->string('last_name_mother')->default('');
			$table->string('nrn_mother')->default('');

			$table->string('first_name_father')->default('');
			$table->string('last_name_father')->default('');
			$table->string('nrn_father')->default('');

			$table->string('phone_number', 10);

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
		Schema::drop('users_parents');
	}

}
