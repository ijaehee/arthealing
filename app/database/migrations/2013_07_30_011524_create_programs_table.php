<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('programs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category');
			$table->integer('exhibition_id');
			$table->string('name');
			$table->string('place')->nullable();
			$table->text('content');
			$table->string('main_image')->nullable();
			$table->string('main_src')->nullable();
			$table->string('sub_image')->nullable();
			$table->string('sub_src')->nullable();
			$table->integer('activated')->default(0);
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
