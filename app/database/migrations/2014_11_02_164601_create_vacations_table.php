<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('vacations', function(Blueprint $table){
		{
			$table->increments('id');
			$table->string('title');
			$table->string('description');
			$table->string('promo_text');
			$table->string('location');
			$table->tinyInteger('min_age');
			$table->tinyInteger('max_age');
			$table->string('transportation');
			$table->tinyInteger('max_participants');
			$table->decimal('base_cost',1,2); //precisie is 1 met 2 cijfers na de komma mogelijk (dus 0,01)
			$table->decimal('one_bm_member_cost',1,2);
			$table->decimal('two_bm_member_cost',1,2);

			//nog eens onderzoeken hoe het zit met de tussentabel
			$table->foreign('monitor_id')->references('id')->on('monitors')
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
