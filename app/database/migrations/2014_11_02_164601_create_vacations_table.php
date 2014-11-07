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
			$table->text('promoText')->nullable();
			$table->string('location');
			$table->tinyInteger('ageFrom')->default(3);
			$table->tinyInteger('ageTo')->default(30);
			$table->string('transportation')->default('');
			$table->tinyInteger('maxParticipants');
			// Precisie is max aantal cijfers (zowel links als rechts) volgens SQL data type :P
			$table->decimal('baseCost', 6, 2); //precisie is 1 met 2 cijfers na de komma mogelijk (dus 0,01)
			$table->decimal('oneBmMemberCost', 6, 2);
			$table->decimal('twoBmMemberCost', 6, 2);

			$table->boolean('taxDeductable')->default(false);
			$table->dateTime('beginDate');
			$table->dateTime('endDate');
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
