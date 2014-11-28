<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('children', function(Blueprint $table) {
			$table->increments('id');
			$table->string('firstName');
			$table->string('lastName');
			$table->string('streetName');
			$table->string('houseNumber');
			$table->string('city');
			$table->string('nrn'); //national registry number

			$table->integer('parents_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vacations');
	}

}
