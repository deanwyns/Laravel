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
			$table->tinyInteger('age_from')->default(3);
			$table->tinyInteger('age_to')->default(30);
			$table->string('transportation')->default('');
			$table->Integer('max_participants');
			$table->Integer('current_participants');
			$table->decimal('baseCost', 6, 2); //precisie is 1 met 2 cijfers na de komma mogelijk (dus 0,01)
			$table->decimal('one_bm_memberCost', 6, 2);
			$table->decimal('two_bm_memberCost', 6, 2);

			$table->boolean('tax_deductable')->default(false);
			$table->dateTime('begin_date');
			$table->dateTime('end_date');
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
