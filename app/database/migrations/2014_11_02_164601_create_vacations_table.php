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

		Schema::create('vacations', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('description');
			$table->text('promo_text')->nullable();
			$table->string('location');
			$table->tinyInteger('min_age')->default(3);
			$table->tinyInteger('max_age')->default(30);
			$table->string('transportation')->default('');
			$table->tinyInteger('max_participants');
			// Precisie is max aantal cijfers (zowel links als rechts) volgens SQL data type :P
			$table->decimal('base_cost', 6, 2); //precisie is 1 met 2 cijfers na de komma mogelijk (dus 0,01)
			$table->decimal('one_bm_member_cost', 6, 2);
			$table->decimal('two_bm_member_cost', 6, 2);

			$table->timestamps();

			//nog eens onderzoeken hoe het zit met de tussentabel
/*			$table->foreign('monitor_id')->references('id')->on('monitors');*/
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
