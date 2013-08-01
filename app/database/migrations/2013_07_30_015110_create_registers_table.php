<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('program_id');
			$table->date('due_date');
			$table->integer('people')->default(0);
			$table->text('etc')->nullable();
			$table->integer('hit')->default(0);
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
		Schema::drop('posts');
	}

}
