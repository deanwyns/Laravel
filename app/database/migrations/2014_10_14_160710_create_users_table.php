<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('password');

			$table->string('first_name_mother')->default('');
			$table->string('last_name_mother')->default('');
			$table->string('nrn_mother')->default('');

			$table->string('first_name_father')->default('');
			$table->string('last_name_father')->default('');
			$table->string('nrn_father')->default('');

			$table->string('phone_number', 10);

			// Als de user iets "heeft", dan moet je manueel de vreemde sleutels toevoegen.
			// De rest doet Laravel wél zelf! Dat is toch zo als je je houdt aan de normale
			// benaming van die vreemde sleutels.
			// Als een user een "Book" (model Book) heeft, dan schrijf je "book_id".
			// Bv. $table->integer('book_id')->unsigned();
			// Laravel gaat dus uit van "modelname_id".
			// 
			// Vreemde sleutels zijn trouwens unsigned, want id is best niet onder nul!
			// Je kunt ook $table->unsignedInteger('bla') doen.

			// Maakt een created_at en updated_at kolom aan. Die worden automatisch geüpdatet bij een save() van het Model
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
		Schema::drop('users');
	}

}
