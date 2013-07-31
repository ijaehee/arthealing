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
			$table->string('place');
			$table->boolean('activated');
			$table->text('content');
			$table->string('main_image');
			$table->string('main_src');
			$table->string('sub_image');
			$table->string('sub_src');
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
